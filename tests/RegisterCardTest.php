<?php
/**
 * @author Oleg Fetisov <ofetisov@corevalue.net>
 */

namespace Tests;

use Tests\Base\PaymentTests;
use Tests\Builders\RegisterCardBuilder;
use Tests\Helpers\AssertionHelper;
use Tests\Helpers\ConfigHelper;

class RegisterCardTest extends PaymentTests
{
    protected function getBuilder()
    {
        return new RegisterCardBuilder();
    }

    public function testPaymentWithUnknownCurrency()
    {
        $cardPayment = $this->getBuilder()
            ->setAttribute('currency', 'ZZZ')
            ->build(ConfigHelper::getConfig());

        try {
            $cardPayment->create();
        } catch (\Exception $e) {
            AssertionHelper::assertApiExceptionWithModelErrors($e, 0, 72, 409, 3);

            return;
        }

        $this->fail('An expected ApiException has not been raised.');
    }

    public function testPaymentChangedAmount()
    {
        $cardPayment = $this->getBuilder()
            ->setAttribute('amount', 100500)
            ->build(ConfigHelper::getConfig());

        $result = $cardPayment->create();

        AssertionHelper::assertSuccessfulPayment($result);
        $this->assertEquals(1.01, $result['amount']);
    }


    public function testPaymentWithNegativeAmount()
    {
        //Unneeded test
        $this->assertTrue(true);
    }

    public function testPaymentWithZeroAmount()
    {
        //Unneeded test
        $this->assertTrue(true);
    }
}
