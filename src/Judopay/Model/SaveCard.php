<?php

namespace Judopay\Model;

use Judopay\DataType;
use Judopay\Model;

class SaveCard extends Model
{
    protected $resourcePath = 'transactions/savecard';
    protected $validApiMethods = array('create');
    protected $attributes
        = array(
            'yourConsumerReference' => DataType::TYPE_STRING,
            'cardNumber'            => DataType::TYPE_STRING,
            'startDate'             => DataType::TYPE_STRING,
            'expiryDate'            => DataType::TYPE_STRING,
            'cv2'                   => DataType::TYPE_STRING,
            'issueNumber'           => DataType::TYPE_STRING,
            'cardAddress'           => DataType::TYPE_ARRAY,
            'currency'              => DataType::TYPE_STRING,
            'judoId'                => DataType::TYPE_STRING,
        );
    protected $requiredAttributes
        = array(
            'yourConsumerReference',
            'cardNumber',
            'cv2',
            'expiryDate',
        );
}
