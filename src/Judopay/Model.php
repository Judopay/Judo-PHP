<?php

namespace Judopay;

class Model
{
	protected $client;

	public function setClient(\GuzzleHttp\Client $client)
	{
		$this->client = $client;
	}

	public function all()
	{
		print_r($this->client->get('/')->getBody());
	}
}