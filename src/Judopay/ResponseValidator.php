<?php

namespace Judopay;

use Guzzle\Plugin\Log\LogPlugin;

class ResponseValidator
{
	protected $response;

	public function __construct(\Guzzle\Http\Message\Response $response)
	{
		$this->response = $response;
		$this->check();
	}

	protected function check()
	{
		switch ($this->response->getStatusCode()) {
			case 400:
				throw new \Judopay\Exception\BadRequest($this->response);
				break;

			case 401:
			case 403:
				throw new \Judopay\Exception\NotAuthorized($this->response);
				break;

			case 404:
				throw new \Judopay\Exception\NotFound($this->response);
				break;

			case 409:
				throw new \Judopay\Exception\Conflict($this->response);
				break;

			case 500:
				throw new \Judopay\Exception\InternalServerError($this->response);
				break;

			case 502:
				throw new \Judopay\Exception\BadGateway($this->response);
				break;

			case 503:
				throw new \Judopay\Exception\ServiceUnavailable($this->response);
				break;

			case 504:
				throw new \Judopay\Exception\GatewayTimeout($this->response);
				break;
		}
	}
}