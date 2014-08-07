<?php

namespace Judopay\Model;

use \Judopay\DataType;

class TokenPayment extends \Judopay\Model
{
    protected $resourcePath = 'transactions/payments';
    protected $validApiMethods = array('create');
    protected $attributes = array(
        'yourConsumerReference' => DataType::TYPE_STRING,
        'yourPaymentReference' => DataType::TYPE_STRING,
        'yourPaymentMetaData' => DataType::TYPE_ARRAY,
        'judoId' => DataType::TYPE_STRING,
        'amount' => DataType::TYPE_FLOAT,
        'consumerToken' => DataType::TYPE_STRING,
        'cardToken' => DataType::TYPE_STRING,
        'cv2' => DataType::TYPE_STRING,
        'consumerLocation' => DataType::TYPE_ARRAY,
        'mobileNumber' => DataType::TYPE_STRING,
        'emailAddress' => DataType::TYPE_STRING
    );
    protected $requiredAttributes = array(
        'yourConsumerReference',
        'yourPaymentReference',
        'judoId',
        'amount',
        'consumerToken',
        'cardToken'
    );
}