<?php

namespace Judopay\Model;

use Judopay\DataType;
use Judopay\Model;

class Void extends Model
{
    protected $resourcePath = 'transactions/voids';
    protected $validApiMethods = array('create');
    protected $attributes
        = array(
            'judoId'               => DataType::TYPE_STRING,
            'amount'               => DataType::TYPE_FLOAT,
            'receiptId'            => DataType::TYPE_STRING,
            'yourPaymentReference' => DataType::TYPE_STRING,
            'currency'             => DataType::TYPE_STRING,
            'yourPaymentMetaData'  => DataType::TYPE_OBJECT,
        );
    protected $requiredAttributes
        = array(
            'judoId',
            'amount',
            'receiptId',
        );
}
