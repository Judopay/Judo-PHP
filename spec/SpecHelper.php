<?php

namespace spec;

use GuzzleHttp\Client;
use GuzzleHttp\Event\EmitterInterface;
use GuzzleHttp\Event\SubscriberInterface;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Message\ResponseInterface;
use GuzzleHttp\Subscriber\Mock;
use Judopay\Configuration;
use GuzzleHttp\Stream\Stream;
use GuzzleHttp\Subscriber\History;

class SpecHelper
{
    public static function getMockResponse($responseCode, $responseBody = null)
    {
        $mockResponse = new Response($responseCode, null, $responseBody);

        return $mockResponse;
    }

    public static function getMockResponseFromFixture($responseCode, $fixtureFile = null)
    {
        $fixtureContent = null;
        if (!empty($fixtureFile)) {
            $fixtureContent = file_get_contents(__DIR__.'/fixtures/'.$fixtureFile);
        }

        $stream = Stream::factory($fixtureContent);

        $mockResponse = new Response(
            $responseCode,  // statusCode
            [],             // headers
            $stream         // StreamInterface body
        );

        return $mockResponse;
    }

    public static function getMockResponseClient($responseCode, $fixtureFile)
    {
        $client = new Client();

        $history = new History();
        $client->getEmitter()->attach($history);

        $mock = new Mock();

        // Preparing the response for the client
        /* @var $mockResponse ResponseInterface */
        $mockResponse = SpecHelper::getMockResponseFromFixture($responseCode, $fixtureFile);
        $mock->addResponse($mockResponse);

        // Guzzle event emitter (onBefore)
        /** @var EmitterInterface $emitter*/
        $emitter = $client->getEmitter();

        // Attach the mock to the emitter
        $emitter->attach($mock);

        return $client;
    }

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
}
