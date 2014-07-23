<?php

namespace Judopay;

class Request
{
	protected $configuration;
	protected $client;

	public function __construct(\Judopay\Configuration $configuration = null)
	{
		$this->configuration = $configuration;
	}

	public function setClient(\Guzzle\Http\Client $client)
	{
		$this->client = $client;
	}

	public function get($url)
	{
		$request = $client->get($url);
		$request->setAuth(
			$this->configuration->get('api_token'),
			$this->configuration->get('api_secret')
		);

		//echo $request->getUrl();
		$response = $request->send();

		return $response;
	}
}