<?php

namespace Judopay\Model;

use Judopay\DataType;
use Judopay\Model;

class CheckEncryptedCard extends Model
{
    protected $resourcePath = 'transactions/checkcard';
    protected $validApiMethods = array('create');
    protected $attributes
        = array(
            'yourConsumerReference' => DataType::TYPE_STRING,
            'yourPaymentReference'  => DataType::TYPE_STRING,
            'currency'              => DataType::TYPE_STRING,
            'judoId'                => DataType::TYPE_STRING,
            'oneUseToken'           => DataType::TYPE_STRING
        );
    protected $requiredAttributes
        = array(
            'yourConsumerReference',
            'yourPaymentReference',
            'oneUseToken'
        );
}
