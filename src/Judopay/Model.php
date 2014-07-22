<?php

namespace Judopay;

class Model
{
	protected $client;
	protected $configuration;
	protected $resourcePath;
	protected $validApiMethods;

	public function __construct(\Judopay\Configuration $configuration = null)
	{
		$this->configuration = $configuration;
	}

	public function setClient(\Guzzle\Http\Client $client)
	{
		$this->client = $client;
	}

	public function all()
	{
		$requestUrl = $this->configuration->get('endpoint_url').'/'.$this->resourcePath;
        $request = $this->client->get($requestUrl);
        $response = $request->send();
        return (string)$response->getBody();
	}
}