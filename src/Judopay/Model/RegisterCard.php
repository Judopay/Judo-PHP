<?php

namespace Judopay\Model;

use Judopay\DataType;
use Judopay\Model;

class RegisterCard extends Model
{
    protected $resourcePath = 'transactions/registercard';
    protected $validApiMethods = array('create');
    protected $attributes
        = array(
            'yourConsumerReference' => DataType::TYPE_STRING,
            'yourPaymentReference'  => DataType::TYPE_STRING,
            'cardNumber'            => DataType::TYPE_STRING,
            'expiryDate'            => DataType::TYPE_STRING,
            'cv2'                   => DataType::TYPE_STRING,
            'amount'                => DataType::TYPE_FLOAT,
            'currency'              => DataType::TYPE_STRING,
            'judoId'                => DataType::TYPE_STRING,
            'yourPaymentMetaData'   => DataType::TYPE_OBJECT,
        );
    protected $requiredAttributes
        = array(
            'yourConsumerReference',
            'yourPaymentReference',
            'judoId',
            'cardNumber',
            'expiryDate',
            'cv2',
        );
}
