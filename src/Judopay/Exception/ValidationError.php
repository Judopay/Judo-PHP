<?php

namespace Judopay\Exception;

class ValidationError extends \RuntimeException
{
    /** @var array */
    protected $modelErrors;

    /**
     * ValidationError constructor.
     * @param string $message
     * @param array  $modelErrors
     */
    public function __construct($message, $modelErrors = array())
    {
        $this->message = $message;
        $this->modelErrors = $modelErrors;
    }

    /**
     * Returns string representation of error
     * @return string
     */
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

    /** @inheritdoc */
    public function __toString()
    {
        return $this->getSummary();
    }

    /**
     * Array of model errors
     * @return array
     */
    public function getModelErrors()
    {
        return $this->modelErrors;
    }

    /**
     * String representation of Model errors
     * @return null|string
     */
    protected function getModelErrorSummary()
    {
        if (!is_array($this->modelErrors)) {
            return null;
        }

        return join('; ', $this->modelErrors);
    }
}
