<?php

namespace Judopay\Model;

use Judopay\DataType;
use Judopay\Model;

class TokenPayment extends Model
{
    protected $resourcePath = 'transactions/payments';
    protected $validApiMethods = array('create');
    protected $attributes
        = array(
            'yourConsumerReference'     => DataType::TYPE_STRING,
            'yourPaymentReference'      => DataType::TYPE_STRING,
            'yourPaymentMetaData'       => DataType::TYPE_OBJECT,
            'judoId'                    => DataType::TYPE_STRING,
            'amount'                    => DataType::TYPE_FLOAT,
            'consumerToken'             => DataType::TYPE_STRING,
            'cardToken'                 => DataType::TYPE_STRING,
            'cv2'                       => DataType::TYPE_STRING,
            'phoneCountryCode'          => DataType::TYPE_STRING,
            'mobileNumber'              => DataType::TYPE_STRING,
            'emailAddress'              => DataType::TYPE_STRING,
            'currency'                  => DataType::TYPE_STRING,
            'clientDetails'             => DataType::TYPE_OBJECT,

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
            'yourPaymentReference',
            'judoId',
            'amount',
            'cardToken',
        );
}
