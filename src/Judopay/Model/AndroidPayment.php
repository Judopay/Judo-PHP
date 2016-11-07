<?php

namespace Judopay\Model;

use Judopay\DataType;
use Judopay\Model;

class AndroidPayment extends Model
{
    protected $resourcePath = 'transactions/payments';
    protected $validApiMethods = array('create');
    protected $attributes
        = array(
            'yourConsumerReference' => DataType::TYPE_STRING,
            'yourPaymentReference'  => DataType::TYPE_STRING,
            'yourPaymentMetaData'   => DataType::TYPE_OBJECT,
            'judoId'                => DataType::TYPE_STRING,
            'amount'                => DataType::TYPE_FLOAT,
            'currency'              => DataType::TYPE_STRING,
            'clientDetails'         => DataType::TYPE_OBJECT,
            'wallet'                => DataType::TYPE_WALLET,
        );
    protected $requiredAttributes
        = array(
            'yourConsumerReference',
            'yourPaymentReference',
            'judoId',
            'amount',
            'currency',
            'wallet',
        );
}
