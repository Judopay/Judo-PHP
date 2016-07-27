<?php

namespace Tests\Builders;

class SaveCardBuilder extends AbstractModelBuilder
{
    public function __construct()
    {
        $this->attributeValues = [
            'yourConsumerReference' => '12345',
            'cardNumber'            => '4976000000003436',
            'expiryDate'            => '12/20',
            'cv2'                   => 452,
        ];
    }
}
