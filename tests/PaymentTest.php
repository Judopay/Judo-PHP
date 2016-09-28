<?php

namespace Tests;

use Tests\Base\PaymentTests;
use Tests\Builders\CardPaymentBuilder;

class PaymentTest extends PaymentTests
{
    protected function getBuilder()
    {
        return new CardPaymentBuilder();
    }
}
