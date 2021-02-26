<?php
namespace Judopay\Model\Inner;

class PrimaryAccountDetails extends TransmittedField
{
    static protected $fieldName = 'primaryAccountDetails';
    protected $requiredAttributes
        = array(
            'name',
            'accountNumber',
            'dateOfBirth',
            'postCode',
        );
}
