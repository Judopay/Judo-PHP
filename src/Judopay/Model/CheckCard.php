<?php

namespace Judopay\Model;

use Judopay\DataType;
use Judopay\Model;

class CheckCard extends Model
{
    protected $resourcePath = 'transactions/checkcard';
    protected $validApiMethods = array('create');
    protected $attributes
        = array(
            'yourConsumerReference' => DataType::TYPE_STRING,
            'yourPaymentReference'  => DataType::TYPE_STRING,
            'cardNumber'            => DataType::TYPE_STRING,
            'expiryDate'            => DataType::TYPE_STRING,
            'cv2'                   => DataType::TYPE_STRING,
            'currency'              => DataType::TYPE_STRING,
            'judoId'                => DataType::TYPE_STRING,
            'yourPaymentMetaData'   => DataType::TYPE_OBJECT,

            'challengeRequestIndicator' => DataType::TYPE_CHALLENGE_INDICATOR,
            'scaExemption'              => DataType::TYPE_SCA_EXEMPTION,

            // Inner objects
            'primaryAccountDetails'     => DataType::TYPE_PRIMARY_ACCOUNT_DETAILS,
            'threeDSecure'              => DataType::TYPE_THREE_D_SECURE_TWO,
        );
    protected $requiredAttributes
        = array(
            'yourConsumerReference',
            'yourPaymentReference',
            'judoId',
            'cardNumber',
            'expiryDate',
            'cv2',
        );
}
