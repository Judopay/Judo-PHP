<?php

namespace Judopay;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Message\FutureResponse;
use GuzzleHttp\Message\Request as GuzzleRequest;
use GuzzleHttp\Ring\Future\FutureArray;
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

        // Set SSL connection
        $this->client->setDefaultOption(
            'verify',
            __DIR__.'/../../cert/digicert_sha256_ca.pem'
        );
    }

    /**
     * Make a GET request to the specified resource path
     * @param string $resourcePath
     * @throws ApiException
     * @return FutureArray|FutureResponse
     */
    public function get($resourcePath)
    {
        $endpointUrl = $this->configuration->get('endpointUrl');

        $request = $this->client->createRequest(
            'GET',
            $endpointUrl.'/'.$resourcePath,
            [
                'json' => null
            ]
        );

        return $this->send($request);
    }

    /**
     * Make a POST request to the specified resource path
     * @param string $resourcePath
     * @param array  $data
     * @return FutureArray|FutureResponse
     */
    public function post($resourcePath, $data)
    {
        $endpointUrl = $this->configuration->get('endpointUrl');

        $request = $this->client->createRequest(
            'POST',
            $endpointUrl.'/'.$resourcePath,
            [
                'json' => $data
            ]
        );

        return $this->send($request);
    }

    public function setRequestHeaders(GuzzleRequest $request)
    {
        $request->setHeader('api-version', $this->configuration->get('apiVersion'));
        $request->setHeader('Accept', 'application/json; charset=utf-8');
        $request->setHeader('Content-Type', 'application/json');
        $request->setHeader('User-Agent', $this->configuration->get('userAgent'));
    }

    public function setRequestAuthentication(GuzzleRequest $request)
    {
        $this->configuration->validate();
        $oauthAccessToken = $this->configuration->get('oauthAccessToken');

        // Do we have an oAuth2 access token?
        if (!empty($oauthAccessToken)) {
            $request->setHeader('Authorization', 'Bearer ' . $oauthAccessToken);
        } else {
            // Otherwise, use basic authentication
            $basicAuth =  $this->configuration->get('apiToken'). ":" . $this->configuration->get('apiSecret');
            $request->setHeader('Authorization', 'Basic ' . base64_encode($basicAuth));
        }
    }

    /**
     * Configuration getter
     * @return Configuration
     */
    public function getConfiguration()
    {
        return $this->configuration;
    }

    /**
     * @param GuzzleRequest $guzzleRequest
     * @throws ApiException
     * @return FutureArray|FutureResponse
     */
    protected function send(GuzzleRequest $guzzleRequest)
    {
        $this->setRequestHeaders($guzzleRequest);
        $this->setRequestAuthentication($guzzleRequest);

        try {
            $guzzleResponse = $this->client->send($guzzleRequest);
        } catch (BadResponseException $e) {
            // Guzzle throws an exception when it encounters a 4xx or 5xx error
            // Rethrow the exception so we can raise our custom exception classes
            throw ApiException::factory($e->getResponse());
        }


        return $guzzleResponse;
    }
}
