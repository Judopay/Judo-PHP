<?php

namespace Tests;

use Tests\Base\TokenPaymentTests;
use Tests\Builders\TokenPaymentBuilder;

class TokenPaymentTest extends TokenPaymentTests
{
    /** @inheritdoc */
    protected function getBuilder()
    {
        return new TokenPaymentBuilder(self::CONSUMER_REFERENCE, $this->consumerToken, $this->cardToken);
    }
}
