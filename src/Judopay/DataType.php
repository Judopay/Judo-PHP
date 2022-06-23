<?php

namespace Judopay;

use Judopay\Exception\ValidationError;
use Judopay\Model\Inner\GooglePayWallet;
use Judopay\Model\Inner\PkPayment;
use Judopay\Model\Inner\Wallet;
use Judopay\Model\Inner\PrimaryAccountDetails;
use Judopay\Model\Inner\ThreeDSecureTwo;

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
    const TYPE_THREE_D_SECURE_TWO = 'three_d_secure_two';

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
                if (strcasecmp($value, "recurring") != 0
                    && strcasecmp($value, "mit") != 0) {
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

            case static::TYPE_THREE_D_SECURE_TWO:
                $authenticationSourceValues = array(
                    "browser",
                    "stored_recurring",
                    "mobile_sdk");
                $methodCompletionValues = array(
                    "yes",
                    "no",
                    "unavailable");
                $challengeRequestIndicatorValues = array(
                    "nopreference",
                    "nochallenge",
                    "challengepreferred",
                    "challengeasmandate");
                $scaExemptionValues = array(
                    "lowvalue",
                    "securecorporate",
                    "trustedbeneficiary",
                    "transactionriskanalysis");

                if (!in_array(strtolower($value['authenticationSource']), $authenticationSourceValues)) {
                    throw new ValidationError('Invalid authenticationSource value');
                }

                // If present, provided value for methodCompletion part of the enum
                if (array_key_exists('methodCompletion', $value)) {
                    if (!in_array(strtolower($value['methodCompletion']), $methodCompletionValues)) {
                        throw new ValidationError('Invalid methodCompletion value');
                    }
                }

                // If present, provided value for challengeRequestIndicator part of the enum
                if (array_key_exists('challengeRequestIndicator', $value)) {
                    if (!in_array(strtolower($value['challengeRequestIndicator']), $challengeRequestIndicatorValues)) {
                        throw new ValidationError('Invalid challenge indicator value');
                    }
                }

                // If present, provided value for scaExemption part of the enum
                if (array_key_exists('scaExemption', $value)) {
                    if (!in_array(strtolower($value['scaExemption']), $scaExemptionValues)) {
                        throw new ValidationError('Invalid SCA exemption value');
                    }
                }

                $threeDSecureTwo = ThreeDSecureTwo::factory($value);
                return $threeDSecureTwo->toObject();
        }

        return $value;
    }
}
