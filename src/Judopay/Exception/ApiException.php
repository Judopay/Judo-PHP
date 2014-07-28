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

    public function getParsedBody()
    {
    	return $this->response->json();
    }

    public function getModelErrors()
    {
    	$parsedBody = $this->getParsedBody();
    	if (!isset($parsedBody['modelErrors']))
    	{
    		return null;
    	}

    	return $parsedBody['modelErrors'];
    }
}
