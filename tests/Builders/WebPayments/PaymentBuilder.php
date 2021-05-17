<?php

namespace Tests\Builders\WebPayments;

use Tests\Builders\AbstractModelBuilder;

class PaymentBuilder extends AbstractModelBuilder
{
    public function __construct()
    {
        $this->attributeValues = array(
            'yourConsumerReference' => '12345',
            'amount'                => 1.02
        );
    }
}
