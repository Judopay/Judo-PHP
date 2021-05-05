<?php

namespace Tests;

use PHPUnit_Framework_Assert as Assert;
use Tests\Base\PaymentTests;
use Tests\Builders\CardPaymentBuilder;
use Tests\Helpers\AssertionHelper;
use Tests\Helpers\ConfigHelper;

class PaymentTest extends PaymentTests
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

    public function testPaymentWithInvalidChallengeRequestIndicator()
    {
        $cardPayment = $this->getBuilder()
            ->setAttribute('challengeRequestIndicator', "test");
        try {
            $cardPayment->build(ConfigHelper::getCybersourceConfig());
            $this->fail('An expected ValidationError has not been raised.');
        } catch (\Exception $e) {
            Assert::assertEquals("Invalid challenge indicator value", $e->getMessage());
        }
    }

    public function testPaymentWithValidChallengeRequestIndicator()
    {
        $cardPayment = $this->getBuilder()
            ->setAttribute('challengeRequestIndicator', "noPreference");
        try {
            $cardPayment->build(ConfigHelper::getCybersourceConfig());
            Assert::assertEquals("noPreference", $cardPayment->getAttributeValues()["challengeRequestIndicator"]);
        } catch (\Exception $e) {
            $this->fail('No exception should have been raised.');
        }
    }
}
