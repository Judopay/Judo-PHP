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

			case 401:
			case 403:
				throw new \Judopay\Exception\NotAuthorized;
				break;

			case 404:
				throw new \Judopay\Exception\NotFound;
				break;

			case 409:
				throw new \Judopay\Exception\Conflict;
				break;

			case 500:
				throw new \Judopay\Exception\InternalServerError;
				break;

			case 502:
				throw new \Judopay\Exception\BadGateway;
				break;

			case 503:
				throw new \Judopay\Exception\ServiceUnavailable;
				break;

			case 504:
				throw new \Judopay\Exception\GatewayTimeout;
				break;
		}
	}
}