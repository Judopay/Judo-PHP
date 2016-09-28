<?php

namespace Tests;

use Tests\Base\TokenPaymentTests;
use Tests\Builders\TokenPreauthBuilder;

class TokenPreauthTest extends TokenPaymentTests
{
    /** @inheritdoc */
    protected function getBuilder()
    {
        return new TokenPreauthBuilder(self::CONSUMER_REFERENCE, $this->consumerToken, $this->cardToken);
    }
}
