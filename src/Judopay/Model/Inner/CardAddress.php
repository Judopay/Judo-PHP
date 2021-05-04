<?php
namespace Judopay\Model\Inner;

use Judopay\DataType;

class CardAddress extends TransmittedField
{
    static protected $fieldName = 'cardAddress';

    protected $attributes
        = array(
            'address1'     => DataType::TYPE_STRING,
            'address2'     => DataType::TYPE_STRING,
            'address3'     => DataType::TYPE_STRING,
            'town'         => DataType::TYPE_STRING,
            'postCode'     => DataType::TYPE_STRING,
            'countryCode'  => DataType::TYPE_STRING,
        );

    protected $requiredAttributes
        = array(
            'postCode'
        );
}
