<?php

namespace Judopay;

class Model
{
	protected $client;

	public function setClient(\Guzzle\Http\Client $client)
	{
		$this->client = $client;
	}

	public function all()
	{
        $request = $this->client->get('http://www.test.com/');
        $response = $request->send();
        return (string)$response->getBody();
	}
}