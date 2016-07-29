<?php
/**
 * @author Oleg Fetisov <ofetisov@corevalue.net>
 */

namespace Tests;

use Tests\Builders\CardPreauthBuilder;

class PreauthTest extends BasePaymentTests
{
    protected function getBuilder()
    {
        return new CardPreauthBuilder();
    }
}
