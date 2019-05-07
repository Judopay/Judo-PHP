<?php

namespace Judopay;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
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
     * Make a GET request to the specified resource path
     *
     * @param string $resourcePath
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws ApiException
     */
    public function get($resourcePath)
    {
        $endpointUrl = $this->configuration->get('endpointUrl');

        return $this->send('GET', $endpointUrl.'/'.$resourcePath);
    }

    /**
     * Make a POST request to the specified resource path
     *
     * @param string $resourcePath
     * @param array  $data
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post($resourcePath, $data)
    {
        $endpointUrl = $this->configuration->get('endpointUrl');

        return $this->send('POST', $endpointUrl.'/'.$resourcePath, [
            'json' => $data,
        ]);
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
     * @param                 $method
     * @param string          $url
     * @param array           $body
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    protected function send($method, $url, array $body = [])
    {
        try {
            $guzzleResponse = $this->client->request($method, $url, $body);
        } catch (RequestException $e) {
            // Guzzle throws an exception when it encounters a 4xx or 5xx error
            // Rethrow the exception so we can raise our custom exception classes
            throw ApiException::factory($e->getResponse());
        }


        return $guzzleResponse;
    }
}
