<?php

namespace Tests\Builders;

class TokenPaymentBuilder extends AbstractModelBuilder
{
    public function __construct()
    {
        $this->attributeValues = [
            'yourConsumerReference' => '12345',
            'yourPaymentReference'  => '12345',
            'judoId'                => '123-456-789',
            'amount'                => 1.01,
            'consumerToken'         => '3UW4DV9wI0oKkMFS',
            'cardToken'             => 'SXw4hnv1vJuEujQR',
            'cv2'                   => 452,
        ];
    }
}
