<?php

namespace Judopay;

class DataType
{
    const TYPE_STRING = 'string';
    const TYPE_FLOAT = 'float';
    const TYPE_INTEGER = 'int';
    const TYPE_ARRAY = 'array';

    public static function coerce($targetDataType, $value)
    {
        switch ($targetDataType) {
            case DataType::TYPE_FLOAT:
                // Check that the provided value appears numeric
                if (!is_numeric($value)) {
                    throw new \OutOfBoundsException('Invalid float value');
                }
                return (float)$value;

            case DataType::TYPE_ARRAY:
                if (!is_array($value)) {
                    $value = array($value);
                }
                return $value;

            case DataType::TYPE_INTEGER:
                return (int)$value;
        }

        return $value;
    }
}