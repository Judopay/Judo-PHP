<?php

namespace spec;

use Judopay\Configuration;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7;

/*
 * Test the client without sending the requests
 */
class SpecHelper
{
    /**
     * Returns a mock configuration
     */
    public static function getConfiguration()
    {
        $configuration = new Configuration(
            array(
                'apiToken'  => 'token',
                'apiSecret' => 'secret',
                'judoId'    => '123-456',
            )
        );

        return $configuration;
    }

    /**
     * Creates a mock Handler with a response in the queue
     * @param $mockResponse
     * @return HandlerStack
     */
    public static function getMockResponseHandler($mockResponse)
    {
        $mock = new MockHandler([$mockResponse]);
        $handler = HandlerStack::create($mock);

        return $handler;
    }

    /**
     * Creates a mock client with the provided body
     * @param $responseCode
     * @param $responseBody
     * @return Client
     */
    public static function getMockResponseClientFromBody($responseCode, $responseBody)
    {
        // Create the response
        $mockResponse = SpecHelper::getBodyResponse($responseCode, $responseBody);

        // Create the handler with a response
        $handlerStack = SpecHelper::getMockResponseHandler($mockResponse);

        $container = [];
        $history = Middleware::history($container);

        // Add the history middleware to the handler stack.
        $handlerStack->push($history);

        return new Client(['handler' => $handlerStack]);
    }


    public static function getBodyResponse($responseCode, $responseBody = null)
    {
        $mockResponse = new Response(
            $responseCode,
            $responseBody
        );

        return $mockResponse;
    }

    /**
     * Creates a mock client with the provided fixture
     * @param $responseCode
     * @param $fixtureFile
     * @return Client
     */
    public static function getMockResponseClientFromFixture($responseCode, $fixtureFile)
    {
        // Create the response
        $mockResponse = SpecHelper::getFixtureResponse($responseCode, $fixtureFile);

        // Create the handler with a response
        $handlerStack = SpecHelper::getMockResponseHandler($mockResponse);

        $container = [];
        $history = Middleware::history($container);

        // Add the history middleware to the handler stack.
        $handlerStack->push($history);

        return new Client(['handler' => $handlerStack]);
    }

    public static function getFixtureResponse($responseCode, $fixtureFile = null)
    {
        $fixtureContent = null;
        if (!empty($fixtureFile)) {
            $fixtureContent = file_get_contents(__DIR__.'/fixtures/'.$fixtureFile);
        }

        $stream = Psr7\Utils::streamFor($fixtureContent);

        $mockResponse = new Response(
            $responseCode,  // statusCode
            [],             // headers
            $stream         // StreamInterface body
        );

        return $mockResponse;
    }
}
