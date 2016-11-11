<?php

namespace Judopay;

use Judopay\Exception\ValidationError;
use Judopay\Model\Inner\PkPayment;
use Judopay\Model\Inner\Wallet;

class DataType
{
    const TYPE_STRING = 'string';
    const TYPE_FLOAT = 'float';
    const TYPE_INTEGER = 'int';
    const TYPE_ARRAY = 'array';
    const TYPE_OBJECT = 'object';
    const TYPE_PK_PAYMENT = 'pk_payment';
    const TYPE_WALLET = 'wallet';

    public static function coerce($targetDataType, $value)
    {
        switch ($targetDataType) {
            case static::TYPE_FLOAT:
                // Check that the provided value appears numeric
                if (!is_numeric($value)) {
                    throw new ValidationError('Invalid float value');
                }

                return (float)$value;

            case static::TYPE_ARRAY:
                if (!is_array($value)) {
                    $value = array($value);
                }

                return $value;

            case static::TYPE_OBJECT:
                if (!is_object($value)) {
                    $value = (object)$value;
                }

                return $value;

            case static::TYPE_PK_PAYMENT:
                $pkPayment = PkPayment::factory($value);

                return $pkPayment->toObject();

            case static::TYPE_WALLET:
                $wallet = Wallet::factory($value);

                return $wallet->toObject();

            case static::TYPE_INTEGER:
                return (int)$value;
        }

        return $value;
    }
}
