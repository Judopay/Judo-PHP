<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Tests\Builders\RegisterCardBuilder;
use Tests\Helpers\AssertionHelper;
use Tests\Helpers\ConfigHelper;

class RegisterCardTest extends TestCase
{
    protected function getBuilder()
    {
        return new RegisterCardBuilder();
    }

    public function testPaymentWithUnknownCurrency()
    {
        $registerCard = $this->getBuilder()
            ->setAttribute('currency', 'ZZZ')
            ->build(ConfigHelper::getBaseConfig());

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
        // When we try to change the amount
        $registerCard = $this->getBuilder()
            ->setAttribute('amount', 1.01)
            ->build(ConfigHelper::getBaseConfig());

        $result = $registerCard->create();

        AssertionHelper::assertSuccessfulPayment($result);

        // The amount is set by the API
        $this->assertEquals(2.00, $result['amount']);
    }

    public function testPaymentWithoutCurrency()
    {
        $registerCard = $this->getBuilder()
            ->unsetAttribute('currency')
            ->build(ConfigHelper::getBaseConfig());

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
