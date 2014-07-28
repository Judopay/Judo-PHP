<?php

namespace Judopay\Exception;

class ApiException extends \Exception
{
	protected $response;

	public function __construct(\Guzzle\Http\Message\Response $response)
	{
		$this->response = $response;
	}

	public function getHttpStatusCode()
	{
		return $this->response->getStatusCode();
	}

    public function getHttpBody()
    {
        return (string)$this->response->getBody();
    }
}
