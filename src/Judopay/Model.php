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
        $request = new \Judopay\Request($this->configuration);
        $request->setClient($this->client);
        return $request->get($this->resourcePath)->json();
	}

	public function find($resourceId)
	{
        $request = new \Judopay\Request($this->configuration);
        $request->setClient($this->client);
        return $request->get($this->resourcePath.'/'.(int)$resourceId)->json();
	}
}
