<?php

namespace spec;

use GuzzleHttp\Client;
use GuzzleHttp\Message\Response;
use GuzzleHttp\Subscriber\Mock;
use GuzzleHttp\Subscriber\Prepare;
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
            [],   // headers
            $stream // StreamInterface body
        );

        return $mockResponse;
    }

    public static function getMockResponseClient($responseCode, $fixtureFile)
    {
        $client = new Client();
        $history = new History();

        $mock = new Mock();
        $mockResponse = SpecHelper::getMockResponseFromFixture($responseCode, $fixtureFile);
        $mock->addResponse($mockResponse);

        $client->setDefaultOption('subscribers', [$history, $mock]);  // Is that the way to set the mock?

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
