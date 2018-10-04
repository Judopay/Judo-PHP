<?php

namespace Judopay\Model;

use Judopay\DataType;
use Judopay\Model;

class RegisterEncryptedCard extends Model
{
    protected $resourcePath = 'transactions/registercard';
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
