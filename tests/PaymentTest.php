<?php

namespace Tests;

use PHPUnit_Framework_Assert as Assert;
use Tests\Base\ThreeDSecureTwoTests;
use Tests\Builders\CardPaymentBuilder;
use Tests\Helpers\ConfigHelper;

class PaymentTest extends ThreeDSecureTwoTests
{
    protected function getBuilder()
    {
        return new CardPaymentBuilder();
    }

    public function testBuildRecurringInvalidTypeAttribute()
    {
        $cardPayment = $this->getBuilder()
            ->setAttribute('recurringPaymentType', "aaa");

        try {
            $cardPayment->build(ConfigHelper::getCybersourceConfig());
        } catch (\Exception $e) {
            Assert::assertEquals($e->getMessage(), "Invalid recurring type value");
            return;
        }

        $this->fail('An expected Exception has not been raised.');
    }

    public function testBuildRecurringValidTypeAttribute()
    {
        $cardPayment = $this->getBuilder()
            ->setAttribute('recurringPaymentType', "mit");

        try {
            $cardPayment->build(ConfigHelper::getCybersourceConfig());
        } catch (\Exception $e) {
            $this->fail('An Exception should not have been raised.');
        }

        Assert::assertEquals("mit", $cardPayment->getAttributeValues()["recurringPaymentType"]);
    }
}
