<?php

namespace Judopay\Model;

use Judopay\DataType;
use Judopay\Model;

class EncryptDetails extends Model
{
    protected $resourcePath = 'encryptions/paymentDetails';
    protected $validApiMethods = array('create');
    protected $attributes
        = array(
            'judoId'                => DataType::TYPE_STRING,
            'cardNumber'            => DataType::TYPE_STRING,
            'expiryDate'            => DataType::TYPE_STRING,
            'cv2'                   => DataType::TYPE_STRING
        );
    protected $requiredAttributes
        = array(
            'judoId',
            'cardNumber',
            'expiryDate',
            'cv2',
        );
}
