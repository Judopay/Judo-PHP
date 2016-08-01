<?php
/**
 * @author Oleg Fetisov <ofetisov@corevalue.net>
 */

namespace Tests;

use Tests\Base\PaymentTests;
use Tests\Builders\CardPreauthBuilder;

class PreauthTest extends PaymentTests
{
    protected function getBuilder()
    {
        return new CardPreauthBuilder();
    }
}
