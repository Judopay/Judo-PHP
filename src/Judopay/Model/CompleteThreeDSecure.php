<?php
namespace Judopay\Model;

use Judopay\DataType;
use Judopay\Model;

class CompleteThreeDSecure extends Model
{
    protected $resourcePath = 'transactions';
    protected $validApiMethods = array('update');

    protected $attributes
        = array(
            'receiptId'     => DataType::TYPE_STRING,
            'md'            => DataType::TYPE_STRING,
            'paRes'         => DataType::TYPE_STRING
        );

    protected $requiredAttributes
        = array(
            'receiptId',
            'md',
            'paRes'
        );
}
