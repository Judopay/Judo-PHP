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
				throw new \Judopay\Exception\BadRequest('Bad Request', $this->response);
				break;

			case 401:
			case 403:
				throw new \Judopay\Exception\NotAuthorized('Not Authorized', $this->response);
				break;

			case 404:
				throw new \Judopay\Exception\NotFound('Not Found', $this->response);
				break;

			case 409:
				throw new \Judopay\Exception\Conflict('Conflict', $this->response);
				break;

			case 500:
				throw new \Judopay\Exception\InternalServerError('Internal Server Error', $this->response);
				break;

			case 502:
				throw new \Judopay\Exception\BadGateway('Bad Gateway', $this->response);
				break;

			case 503:
				throw new \Judopay\Exception\ServiceUnavailable('Search Unavailable', $this->response);
				break;

			case 504:
				throw new \Judopay\Exception\GatewayTimeout('Gateway Timeout', $this->response);
				break;
		}
	}
}