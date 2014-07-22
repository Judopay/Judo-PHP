<?php

namespace Judopay;

class SpecHelper
{
	public static function getMockResponsePlugin($responseCode, $headers, $body)
	{
        $plugin = new \Guzzle\Plugin\Mock\MockPlugin();
        $mockResponse = new \Guzzle\Http\Message\Response($responseCode, $headers, $body);
        $plugin->addResponse($mockResponse);

        return $plugin;
	}
}