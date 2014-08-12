<?php

namespace Judopay\Exception;

class ApiException extends \RuntimeException
{
    protected $response;

    public function __construct($message, \Guzzle\Http\Message\Response $response)
    {
        $this->message = $message;
        $this->response = $response;
    }

    public function getSummary()
    {
        // As a sensible default, use the class name
        $message = get_class($this);

        // See if we have an error message in the response
        $apiErrorMessage = $this->getBodyAttribute('errorMessage');
        if (!empty($apiErrorMessage)) {
            $message = $apiErrorMessage;
        }

        // Append model errors summary if applicable
        $modelErrorSummary = $this->getModelErrorSummary();
        if (!empty($modelErrorSummary)) {
            $message .= ' ('.$modelErrorSummary.')';
        }

        return $message;
    }

    public function __toString()
    {
        return $this->getSummary();
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
        return $this->getBodyAttribute('modelErrors');
    }

    protected function getBodyAttribute($attributeName)
    {
        $parsedBody = $this->getParsedBody();
        if (!isset($parsedBody[$attributeName]))
        {
            return null;
        }

        return $parsedBody[$attributeName];
    }

    protected function getModelErrorSummary()
    {
        $modelErrors = $this->getModelErrors();
        if (!is_array($modelErrors)) {
            return null;
        }

        return join('; ', $modelErrors);
    }
}