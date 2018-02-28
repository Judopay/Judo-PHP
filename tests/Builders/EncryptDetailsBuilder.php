<?php

namespace Tests\Builders;

class EncryptDetailsBuilder extends AbstractModelBuilder
{
    public function __construct()
    {
        $this->attributeValues = array(
            'cardNumber'            => '4976000000003436',
            'expiryDate'            => '12/20',
            'cv2'                   => 452,
        );
    }
}
