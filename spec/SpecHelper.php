<?php

namespace Judopay;

class SpecHelper
{
    public static function getMockResponse($responseCode, $responseBody = null)
    {
        $mockResponse = new \Guzzle\Http\Message\Response($responseCode, null, $responseBody);
        return $mockResponse;
    }

    public static function getMockResponseFromFixture($responseCode, $fixtureFile = null)
    {
        $fixtureContent = null;
        if (!empty($fixtureFile)) {
            $fixtureContent = file_get_contents(__DIR__.'/fixtures/'.$fixtureFile);
        }

        $mockResponse = new \Guzzle\Http\Message\Response($responseCode, null, $fixtureContent);

        return $mockResponse;
    }

	public static function getMockResponseClient($responseCode, $fixtureFile)
	{
        $client = new \Guzzle\Http\Client();
        $plugin = new \Guzzle\Plugin\Mock\MockPlugin();

        $mockResponse = SpecHelper::getMockResponseFromFixture($responseCode, $fixtureFile);
        $plugin->addResponse($mockResponse);
        $client->addSubscriber($plugin);

        return $client;
	}

	public static function getConfiguration()
	{
        $configuration = new \Judopay\Configuration(array(
                'apiToken' => 'token',
                'apiSecret' => 'secret',
                'judoId' => '123-456'
            )
        );

        return $configuration;
	}
}