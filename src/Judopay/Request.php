<?php

namespace Judopay;

use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Judopay\Exception\ApiException;

class Request
{
    /** @var Configuration */
    protected $configuration;
    /** @var  Client */
    protected $client;

    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Sets the headers and the authentication
     * @return array
     */
    public function getHeaders()
    {
        return [
            'api-version'   => $this->configuration->get('apiVersion'),
            'Accept'        => 'application/json; charset=utf-8',
            'Content-Type'  => 'application/json',
            'User-Agent'    => $this->configuration->get('userAgent'),
            'Authorization' => $this->getRequestAuthenticationHeader()
        ];
    }

    /**
     * Make a GET request to the specified resource path
     * @param string $resourcePath
     * @throws ApiException
     * @return Response
     */
    public function get($resourcePath)
    {
        $headers = $this->getHeaders();

        try {
            $guzzleResponse = $this->client->request(
                'GET',
                $resourcePath,
                [
                    'headers'       => $headers
                ]
            );
        } catch (BadResponseException $e) {
            throw ApiException::factory($e);
        } catch (GuzzleException $e) {
            throw new ApiException($e->getMessage());
        }

        return $guzzleResponse;
    }

    /**
     * Make a POST request to the specified resource path and the provided data
     * @param string $resourcePath
     * @param array $data
     * @return Response
     */
    public function post($resourcePath, $data)
    {
        $headers = $this->getHeaders();

        try {
            $guzzleResponse = $this->client->request(
                'POST',
                $resourcePath,
                [
                    'headers'   => $headers,
                    'json'      => $data
                ]
            );
        } catch (BadResponseException $e) {
            throw ApiException::factory($e);
        } catch (GuzzleException $e) {
            throw new ApiException($e->getMessage());
        }

        return $guzzleResponse;
    }

    /*
     * Gets 'Authorization' header value
     */
    private function getRequestAuthenticationHeader()
    {
        // Make sure we have all the required fields
        $this->configuration->validate();
        $oauthAccessToken = $this->configuration->get('oauthAccessToken');

        // Do we have an oAuth2 access token?
        if (!empty($oauthAccessToken)) {
            return 'Bearer ' . $oauthAccessToken;
        }

        // Otherwise, use basic authentication
        $basicAuth =  $this->configuration->get('apiToken'). ":" . $this->configuration->get('apiSecret');
        return 'Basic ' . base64_encode($basicAuth);
    }

    /**
     * Configuration getter
     * @return Configuration
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }
}
