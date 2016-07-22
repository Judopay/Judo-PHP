<?php

namespace Judopay\Model;

use Judopay\DataType;
use Judopay\Model;

class Refund extends Model
{
    protected $resourcePath = 'transactions/refunds';
    protected $validApiMethods = ['all', 'create', 'validate'];
    protected $attributes
        = [
            'receiptId'            => DataType::TYPE_STRING,
            'yourPaymentReference' => DataType::TYPE_STRING,
            'amount'               => DataType::TYPE_FLOAT,
        ];
    protected $requiredAttributes
        = [
            'receiptId',
            'yourPaymentReference',
            'amount',
        ];
}
