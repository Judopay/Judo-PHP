<?php

namespace Judopay\Test\WebPayments;

class PaymentBuilder extends \Judopay\Test\AbstractModelBuilder
{
    public function __construct()
    {
        $this->attributeValues = array(
            'yourConsumerReference' => '12345',
            'yourPaymentReference' => '12345',
            'judoId' => '123-456-789',
            'amount' => 1.01,
            'partnerServiceFee' => 0.01,
            'clientIpAddress' => '127.0.0.1',
            'clientUserAgent' => 'Mozilla/5.0 (Windows NT 6.2; Win64; x64)...'
        );
    }
}