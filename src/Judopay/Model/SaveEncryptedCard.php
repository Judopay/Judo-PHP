<?php

namespace Judopay\Model;

use Judopay\DataType;
use Judopay\Model;

class SaveEncryptedCard extends Model
{
    protected $resourcePath = 'transactions/savecard';
    protected $validApiMethods = array('create');
    protected $attributes
        = array(
            'yourConsumerReference' => DataType::TYPE_STRING,
            'currency'              => DataType::TYPE_STRING,
            'judoId'                => DataType::TYPE_STRING,
            'oneUseToken'           => DataType::TYPE_STRING
        );
    protected $requiredAttributes
        = array(
            'yourConsumerReference',
            'oneUseToken'
        );
}
