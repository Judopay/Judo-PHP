<?php

namespace Tests\Builders;

class TokenPaymentBuilder extends AbstractModelBuilder
{
    public function __construct(
        $yourConsumerReference = '12345',
        $consumerToken = '3UW4DV9wI0oKkMFS',
        $cardToken = 'SXw4hnv1vJuEujQR'
    ) {
        $this->attributeValues = array(
            'yourConsumerReference' => $yourConsumerReference,
            'amount'                => 1.01,
            'consumerToken'         => $consumerToken,
            'cardToken'             => $cardToken,
            'cv2'                   => 452,
        );
    }
}
