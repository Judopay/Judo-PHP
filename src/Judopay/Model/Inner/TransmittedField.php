<?php
namespace Judopay\Model\Inner;

use Judopay\Exception\ValidationError;
use Judopay\Helper\ArrayHelper;

abstract class TransmittedField
{
    const ERROR_MESSAGE_INVALID_JSON = 'Can\'t decode %s object from JSON';
    const ERROR_MESSAGE_CORRUPTED_OBJECT
        = 'You passed wrong value to the %1$s. Please pass array, json-encoded string or %1$s object';
    /** @var  string Field name and wrapper */
    static protected $fieldName;
    /** @var array Field data */
    protected $data = array();
    /** @var array Attributes that must be present in field */
    protected $requiredAttributes = array();

    /**
     * Factory method
     * @param array|string|static|\StdClass $value field data
     * @return static
     */
    public static function factory($value)
    {
        // if user passes same object
        if ($value instanceof static) {
            return $value;
        }

        // if user passes json string
        if (is_string($value) && (($value = json_decode($value, true)) == false)) {
            throw new ValidationError(
                sprintf(static::ERROR_MESSAGE_INVALID_JSON, get_called_class())
            );
        }

        //if user passes StdClass
        if (is_object($value)) {
            $value = (array)$value;
        }

        // check if we have array at last
        if (!is_array($value)) {
            throw new ValidationError(
                sprintf(static::ERROR_MESSAGE_CORRUPTED_OBJECT, get_called_class())
            );
        }

        //Check if we have wrapper above object
        if (isset($value[static::$fieldName])) {
            $value = $value[static::$fieldName];
        }

        return new static($value);
    }

    /**
     * TransmittedField constructor.
     * @param array $data
     */
    public function __construct(array $data = array())
    {
        $this->data = $data;
    }

    /**
     * Converts field into JSON serializable object
     * @return \StdClass
     */
    public function toObject()
    {
        $this->validate();

        //Needed due to recursive objects structure
        return json_decode(json_encode($this->data));
    }

    /**
     * Check if object contains all of the required attributes
     * @throws ValidationError if some fields are missing
     * @return bool
     */
    protected function validate()
    {
        $errors = array();
        foreach ($this->requiredAttributes as $requiredAttribute) {
            if (!ArrayHelper::keyExists($this->data, $requiredAttribute)) {
                $errors[] = $requiredAttribute.' is missing or empty';
            }
        }

        if (count($errors) > 0) {
            throw new ValidationError(get_called_class().' object misses required fields', $errors);
        }

        return true;
    }
}
