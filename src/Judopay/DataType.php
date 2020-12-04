<?php

namespace Judopay;

use Judopay\Exception\ValidationError;
use Judopay\Model\Inner\GooglePayWallet;
use Judopay\Model\Inner\PkPayment;
use Judopay\Model\Inner\Wallet;
use Judopay\Model\Inner\PrimaryAccountDetails;

class DataType
{
    const TYPE_STRING = 'string';
    const TYPE_FLOAT = 'float';
    const TYPE_INTEGER = 'int';
    const TYPE_BOOLEAN = 'bool';
    const TYPE_ARRAY = 'array';
    const TYPE_OBJECT = 'object';
    const TYPE_PK_PAYMENT = 'pk_payment';
    const TYPE_WALLET = 'wallet';
    const TYPE_GOOGLE_PAY_WALLET = 'google_pay_wallet';
    const TYPE_PRIMARY_ACCOUNT_DETAILS = 'primary_account_details';
    const TYPE_RECURRING_TYPE = 'recurring_type';

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

            case static::TYPE_GOOGLE_PAY_WALLET:
                $googleWallet = GooglePayWallet::factory($value);
                return $googleWallet->toObject();

            case static::TYPE_RECURRING_TYPE:
                // Check that the provided value is one of the recurring payment types
                if (strcasecmp($value, "recurring") != 0 && strcasecmp($value, "mit") != 0) {
                    throw new ValidationError('Invalid recurring type value');
                }
                return $value;

            case static::TYPE_INTEGER:
                return (int)$value;

            case static::TYPE_BOOLEAN:
                return boolval($value);

            case static::TYPE_PRIMARY_ACCOUNT_DETAILS:
                $primaryAccountDetails = PrimaryAccountDetails::factory($value);
                return $primaryAccountDetails->toObject();
        }

        return $value;
    }
}
