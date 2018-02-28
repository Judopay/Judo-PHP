<?php

namespace Judopay\Model;

use Judopay\DataType;
use Judopay\Model;

class OneUseTokenPayment extends Model
{
    protected $resourcePath = 'transactions/preauths';
    protected $validApiMethods = array('create');
    protected $attributes
        = array(
            'oneUseToken'           => DataType::TYPE_STRING,
            'yourConsumerReference' => DataType::TYPE_STRING,
            'yourPaymentReference'  => DataType::TYPE_STRING,
            'judoId'                => DataType::TYPE_STRING,
            'amount'                => DataType::TYPE_FLOAT,
            'currency'              => DataType::TYPE_STRING,
            'yourPaymentMetaData'   => DataType::TYPE_OBJECT,
            'cardAddress'           => DataType::TYPE_ARRAY,
            'mobileNumber'          => DataType::TYPE_STRING,
            'emailAddress'          => DataType::TYPE_STRING,
            'clientDetails'         => DataType::TYPE_OBJECT,
        );
    protected $requiredAttributes
        = array(
            'oneUseToken',
            'yourConsumerReference',
            'yourPaymentReference',
            'judoId',
            'amount',
            'currency'
        );
}
