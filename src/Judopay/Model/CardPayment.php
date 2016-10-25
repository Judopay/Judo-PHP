<?php

namespace Judopay\Model;

use Judopay\DataType;
use Judopay\Model;

class CardPayment extends Model
{
    protected $resourcePath = 'transactions/payments';
    protected $validApiMethods = array('create', 'validate');
    protected $attributes
        = array(
            'yourConsumerReference' => DataType::TYPE_STRING,
            'yourPaymentReference'  => DataType::TYPE_STRING,
            'yourPaymentMetaData'   => DataType::TYPE_OBJECT,
            'judoId'                => DataType::TYPE_STRING,
            'amount'                => DataType::TYPE_FLOAT,
            'cardNumber'            => DataType::TYPE_STRING,
            'currency'              => DataType::TYPE_STRING,
            'expiryDate'            => DataType::TYPE_STRING,
            'cv2'                   => DataType::TYPE_STRING,
            'cardAddress'           => DataType::TYPE_ARRAY,
            'mobileNumber'          => DataType::TYPE_STRING,
            'emailAddress'          => DataType::TYPE_STRING,
            'clientDetails'         => DataType::TYPE_OBJECT,
        );
    protected $requiredAttributes
        = array(
            'yourConsumerReference',
            'yourPaymentReference',
            'judoId',
            'amount',
            'currency',
            'cardNumber',
            'expiryDate',
            'cv2',
        );
}
