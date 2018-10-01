<?php

namespace spec;

use Guzzle\Http\Client;
use Guzzle\Http\Message\Response;
use Guzzle\Plugin\Mock\MockPlugin;
use Judopay\Configuration;

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

        $mockResponse = new Response(
            $responseCode,
            null,
            $fixtureContent
        );

        return $mockResponse;
    }

    public static function getMockResponseClient($responseCode, $fixtureFile)
    {
        $client = new Client();
        $plugin = new MockPlugin();

        $mockResponse = SpecHelper::getMockResponseFromFixture($responseCode, $fixtureFile);
        $plugin->addResponse($mockResponse);
        $client->addSubscriber($plugin);

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
