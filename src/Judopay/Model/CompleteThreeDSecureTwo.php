<?php
namespace Judopay\Model;

use Judopay\DataType;
use Judopay\Model;

class CompleteThreeDSecureTwo extends Model
{
    protected $resourcePath = 'transactions/receiptId/complete3ds';
    protected $validApiMethods = array('update');

    protected $attributes
        = array(
            'receiptId' => DataType::TYPE_STRING,
            'cv2'       => DataType::TYPE_STRING,

            // Inner objects
            'primaryAccountDetails'     => DataType::TYPE_PRIMARY_ACCOUNT_DETAILS,
        );

    protected $requiredAttributes
        = array(
            'receiptId'
        );
}
