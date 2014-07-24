<?php

namespace Judopay;

use Guzzle\Plugin\Log\LogPlugin;

class ResponseValidator
{
	protected $response;

	public function __construct(\Guzzle\Http\Message\Response $response)
	{
		$this->response = $response;
		$this->checkResponseForErrors();
	}

	protected function checkResponseForErrors()
	{
		switch ($this->response->getStatusCode()) {
			case 400:
				throw new \Judopay\Exception\BadRequest;
				break;
		}
	}
}