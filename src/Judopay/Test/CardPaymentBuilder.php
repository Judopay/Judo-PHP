<?php

namespace Judopay\Test;

class CardPaymentBuilder extends AbstractModelBuilder
{
    public function __construct()
    {
        $this->attributeValues = array(
            'yourConsumerReference' => '12345',
            'yourPaymentReference' => '12345',
            'judoId' => '123-456-789',
            'amount' => 1.01,
            'cardNumber' => '4976000000003436',
            'expiryDate' => '12/15',
            'cv2' => 452
        );
    }

    public function setJudoId($judoId)
    {
        $this->attributeValues['judoId'] = $judoId;
    }
}
