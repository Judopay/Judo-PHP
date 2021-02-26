<?php
namespace Judopay\Model;

use Judopay\DataType;
use Judopay\Model;

class ResumeThreeDSecureTwo extends Model
{
    protected $resourcePath = 'transactions/receiptId/resume3ds';
    protected $validApiMethods = array('update');

    protected $attributes
        = array(
            'receiptId'            => DataType::TYPE_STRING,
            'cv2'                  => DataType::TYPE_STRING,

            // Inner objects
            'threeDSecure'         => DataType::TYPE_THREE_D_SECURE_TWO,
        );

    protected $requiredAttributes
        = array(
            'receiptId',
            'cv2',
            'threeDSecure'
        );
}
