<?php

namespace Judopay;

class SpecHelper
{
	public static function getMockResponseClient($responseCode, $fixtureFile)
	{
        $client = new \Guzzle\Http\Client();
        $plugin = new \Guzzle\Plugin\Mock\MockPlugin();
        $fixtureContent = file_get_contents(__DIR__.'/fixtures/'.$fixtureFile);

        $mockResponse = new \Guzzle\Http\Message\Response($responseCode, null, $fixtureContent);
        $plugin->addResponse($mockResponse);
        $client->addSubscriber($plugin);

        return $client;
	}
}