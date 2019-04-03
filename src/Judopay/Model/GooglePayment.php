<?php

namespace Judopay\Model;

use Judopay\DataType;
use Judopay\Model;

class GooglePayment extends Model
{
    protected $resourcePath = 'transactions/payments';
    protected $validApiMethods = array('create');
    protected $attributes
        = array(
            'currency'              => DataType::TYPE_STRING,
            'judoId'                => DataType::TYPE_STRING,
            'yourPaymentReference'  => DataType::TYPE_STRING,
            'amount'                => DataType::TYPE_FLOAT,
            'yourConsumerReference' => DataType::TYPE_STRING,
            'googlePayWallet'       => DataType::TYPE_GOOGLE_PAY_WALLET
        );
    protected $requiredAttributes
        = array(
            'currency',
            'judoId',
            'yourPaymentReference',
            'amount',
            'yourConsumerReference',
            'googlePayWallet'
        );
}
