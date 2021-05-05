<?php

namespace Judopay\Model;

use Judopay\DataType;
use Judopay\Model;

class CheckEncryptedCard extends Model
{
    protected $resourcePath = 'transactions/checkcard';
    protected $validApiMethods = array('create');
    protected $attributes
        = array(
            'yourConsumerReference' => DataType::TYPE_STRING,
            'yourPaymentReference'  => DataType::TYPE_STRING,
            'currency'              => DataType::TYPE_STRING,
            'judoId'                => DataType::TYPE_STRING,
            'oneUseToken'           => DataType::TYPE_STRING,
            'cardAddress'               => DataType::TYPE_ARRAY,
            'phoneCountryCode'          => DataType::TYPE_STRING,
            'mobileNumber'              => DataType::TYPE_STRING,
            'cardHolderName'            => DataType::TYPE_STRING,
            'emailAddress'              => DataType::TYPE_STRING,
            'initialRecurringPayment'   => DataType::TYPE_BOOLEAN,
            'recurringPayment'          => DataType::TYPE_BOOLEAN,
            'relatedReceiptId'          => DataType::TYPE_STRING,
            'recurringPaymentType'      => DataType::TYPE_RECURRING_TYPE,

            // Inner objects
            'primaryAccountDetails'     => DataType::TYPE_PRIMARY_ACCOUNT_DETAILS,
            'threeDSecure'              => DataType::TYPE_THREE_D_SECURE_TWO,
        );
    protected $requiredAttributes
        = array(
            'yourConsumerReference',
            'oneUseToken'
        );
}
