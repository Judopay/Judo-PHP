<?php

namespace Tests;

use Tests\Base\ThreeDSecureTwoTests;
use Tests\Builders\CardPreauthBuilder;

class PreauthTest extends ThreeDSecureTwoTests
{
    protected function getBuilder()
    {
        return new CardPreauthBuilder();
    }
}
