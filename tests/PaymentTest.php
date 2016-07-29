<?php
/**
 * @author Oleg Fetisov <ofetisov@corevalue.net>
 */

namespace Tests;

use Tests\Builders\CardPaymentBuilder;

class PaymentTest extends BasePaymentTests
{
    protected function getBuilder()
    {
        return new CardPaymentBuilder();
    }
}
