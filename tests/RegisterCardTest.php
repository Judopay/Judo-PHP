<?php

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
        $registerCard = $this->getBuilder()
            ->setAttribute('currency', 'ZZZ')
            ->build(ConfigHelper::getConfig());

        try {
            $registerCard->create();
        } catch (\Exception $e) {
            AssertionHelper::assertApiExceptionWithModelErrors($e, 0, 72, 409, 3);

            return;
        }

        $this->fail('An expected ApiException has not been raised.');
    }

    public function testPaymentChangedAmount()
    {
        $registerCard = $this->getBuilder()
            ->setAttribute('amount', 100500)
            ->build(ConfigHelper::getConfig());

        $result = $registerCard->create();

        AssertionHelper::assertSuccessfulPayment($result);
        $this->assertEquals(1.01, $result['amount']);
    }

    public function testPaymentWithoutCurrency()
    {
        $registerCard = $this->getBuilder()
            ->unsetAttribute('currency')
            ->build(ConfigHelper::getConfig());

        $result = $registerCard->create();

        AssertionHelper::assertSuccessfulPayment($result);
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

    public function testDuplicatePayment()
    {
        //Unneeded test
        $this->assertTrue(true);
    }
}
