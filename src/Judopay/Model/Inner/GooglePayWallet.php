<?php
namespace Judopay\Model\Inner;

class GooglePayWallet extends TransmittedField
{
    static protected $fieldName = 'googlePayWallet';
    protected $requiredAttributes
        = array(
            'cardNetwork',
            'cardDetails',
            'token'
        );
}
