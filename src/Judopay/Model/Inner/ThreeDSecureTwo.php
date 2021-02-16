<?php
namespace Judopay\Model\Inner;

class ThreeDSecureTwo extends TransmittedField
{
    static protected $fieldName = 'threeDSecure';
    protected $requiredAttributes
        = array(
            'authenticationSource',
            'methodNotificationUrl',
            'challengeNotificationUrl',
            'methodCompletion',
        );
}
