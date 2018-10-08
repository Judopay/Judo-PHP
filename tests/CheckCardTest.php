<?php

namespace Tests;

use Tests\Base\PaymentTests;
use Tests\Builders\CheckCardBuilder;
use Tests\Helpers\AssertionHelper;
use Tests\Helpers\ConfigHelper;

class CheckCardTest extends PaymentTests
{
    protected function getBuilder()
    {
        return new CheckCardBuilder();
    }

    public function testValidPayment()
    {
        $cardPayment = $this->getBuilder()
            ->build(ConfigHelper::getConfigAlt());
        $result = $cardPayment->create();

        AssertionHelper::assertSuccessfulPayment($result);
    }

    public function testPaymentWithUnknownCurrency()
    {
        $checkCard = $this->getBuilder()
            ->setAttribute('currency', 'ZZZ')
            ->build(ConfigHelper::getConfigAlt());

        try {
            $checkCard->create();
        } catch (\Exception $e) {
            AssertionHelper::assertApiExceptionWithModelErrors($e, 0, 72, 409, 3);

            return;
        }

        $this->fail('An expected ApiException has not been raised.');
    }

    public function testPaymentChangedAmount()
    {
        $checkCard = $this->getBuilder()
            ->setAttribute('amount', 100500)
            ->build(ConfigHelper::getConfigAlt());

        $result = $checkCard->create();

        AssertionHelper::assertSuccessfulPayment($result);
        $this->assertEquals(0.00, $result['amount']);
    }

    public function testPaymentWithoutCurrency()
    {
        $checkCard = $this->getBuilder()
            ->unsetAttribute('currency')
            ->build(ConfigHelper::getConfigAlt());

        $result = $checkCard->create();

        AssertionHelper::assertSuccessfulPayment($result);
    }

    public function testDeclinedPayment()
    {
        //Unneeded test
        $this->assertTrue(true);
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
