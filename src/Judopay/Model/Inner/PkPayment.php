<?php

namespace Judopay\Model\Inner;

use Judopay\Exception\ValidationError;

class PkPayment
{
    const ERROR_MESSAGE_INVALID_JSON = 'Can\'t decode pkPayment object from JSON';
    const ERROR_MESSAGE_CORRUPTED_OBJECT
        = 'You passed wrong value to the PkPayment. Please pass array, json-encoded string or PkPayment object';
    const ERROR_MESSAGE_INVALID_DATA
        = 'PkPayment token array should contain paymentInstrumentName, paymentNetwork & paymentData fields.';
    protected $data;

    public static function factory($value)
    {
        // if user passes PkPayment object
        if ($value instanceof static) {
            return $value;
        }

        // if user passes json string
        if (is_string($value) && (($value = json_decode($value, true)) == false)) {
            throw new ValidationError(static::ERROR_MESSAGE_INVALID_JSON);
        }

        //if user passes StdClass
        if (is_object($value)) {
            $value = (array)$value;
        }

        // check if we have array at last
        if (!is_array($value)) {
            throw new ValidationError(static::ERROR_MESSAGE_CORRUPTED_OBJECT);
        }
        //Check if we have wrapper above object
        if (isset($value['pkPayment'])) {
            $value = $value['pkPayment'];
        }

        return new static($value);
    }

    public function __construct(array $data = array())
    {
        $this->data = $data;
    }

    protected function validate()
    {
        if (isset($this->data['token']) && is_array($this->data['token'])
            && isset($this->data['token']['paymentInstrumentName'])
            && isset($this->data['token']['paymentNetwork'])
            && isset($this->data['token']['paymentData'])
        ) {
            return true;
        }

        return false;
    }

    public function toObject()
    {
        if (!$this->validate()) {
            throw new ValidationError(static::ERROR_MESSAGE_INVALID_DATA);
        }

        //Needed due to recursive objects structure
        return json_decode(json_encode($this->data));
    }
}
