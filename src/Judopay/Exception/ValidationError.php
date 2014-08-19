<?php

namespace Judopay\Exception;

class ValidationError extends \RuntimeException
{
    protected $modelErrors;

    public function __construct($message, $modelErrors)
    {
        $this->message = $message;
        $this->modelErrors = $modelErrors;
    }

    public function getSummary()
    {
        // As a sensible default, use the class name
        $message = get_class($this);

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

    public function getModelErrors()
    {
        return $this->modelErrors;
    }

    protected function getModelErrorSummary()
    {
        if (!is_array($this->modelErrors)) {
            return null;
        }

        return join('; ', $this->modelErrors);
    }
}
