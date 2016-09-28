<?php

namespace Judopay\Exception;

/**
 * Class that represents API field error
 * @package Judopay\Exception
 */
class FieldError
{
    /** @var  int */
    protected $code;
    
    /** @var  string */
    protected $fieldName;
    
    /** @var  string */
    protected $message;
    
    /** @var  string */
    protected $details;

    /**
     * FieldError constructor.
     * @param $message
     * @param $code
     * @param $fieldName
     * @param $details
     */
    public function __construct($message, $code, $fieldName, $details)
    {
        $this->message = $message;
        $this->code = $code;
        $this->fieldName = $fieldName;
        $this->details = $details;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getFieldName()
    {
        return $this->fieldName;
    }

    /**
     * @return string
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * String representation of error
     * @return string
     */
    public function __toString()
    {
        return "field \"{$this->fieldName}\" (code {$this->getCode()}): {$this->getMessage()}";
    }
}
