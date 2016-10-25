<?php

namespace Judopay\Model\WebPayments;

use Judopay\DataType;
use Judopay\Model;

class Payment extends Model
{
    protected $resourcePath = 'webpayments/payments';
    protected $validApiMethods = array('create');
    protected $attributes
        = array(
            'yourConsumerReference' => DataType::TYPE_STRING,
            'yourPaymentReference'  => DataType::TYPE_STRING,
            'yourPaymentMetaData'   => DataType::TYPE_OBJECT,
            'judoId'                => DataType::TYPE_STRING,
            'amount'                => DataType::TYPE_FLOAT,
            'partnerServiceFee'     => DataType::TYPE_FLOAT,
            'clientIpAddress'       => DataType::TYPE_STRING,
            'clientUserAgent'       => DataType::TYPE_STRING,
            'webPaymentOperation'   => 'WebPaymentOperation',
        );
    protected $requiredAttributes
        = array(
            'yourConsumerReference',
            'yourPaymentReference',
            'judoId',
            'amount',
        );
}
