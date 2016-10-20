<?php

namespace Tests\Base;

use PHPUnit_Framework_TestCase;
use Tests\Builders\CardPaymentBuilder;
use Tests\Builders\CardPreauthBuilder;
use Tests\Helpers\AssertionHelper;
use Tests\Helpers\ConfigHelper;

abstract class PaymentTests extends PHPUnit_Framework_TestCase
{
    /**
     * @return CardPaymentBuilder|CardPreauthBuilder
     */
    abstract protected function getBuilder();

    public function testValidPayment()
    {
        $cardPayment = $this->getBuilder()
            ->build(ConfigHelper::getConfig());
        $result = $cardPayment->create();

        AssertionHelper::assertSuccessfulPayment($result);
    }

    public function testDeclinedPayment()
    {
        $cardPayment = $this->getBuilder()
            ->setType(CardPaymentBuilder::INVALID_VISA_CARD)
            ->build(ConfigHelper::getConfig());
        $result = $cardPayment->create();

        AssertionHelper::assertDeclinedPayment($result);
    }

    public function testPaymentWithNegativeAmount()
    {
        $cardPayment = $this->getBuilder()
            ->setAttribute('amount', -1)
            ->build(ConfigHelper::getConfig());

        try {
            $cardPayment->create();
        } catch (\Exception $e) {
            AssertionHelper::assertApiExceptionWithModelErrors($e, 1, 1);

            return;
        }

        $this->fail('An expected ApiException has not been raised.');
    }

    public function testPaymentWithZeroAmount()
    {
        $cardPayment = $this->getBuilder()
            ->setAttribute('amount', 0)
            ->build(ConfigHelper::getConfig());

        try {
            $cardPayment->create();
        } catch (\Exception $e) {
            AssertionHelper::assertApiExceptionWithModelErrors($e, 1, 1);

            return;
        }

        $this->fail('An expected ApiException has not been raised.');
    }

    public function testPaymentWithoutCurrency()
    {
        $this->setExpectedException('\Judopay\Exception\ValidationError', 'Missing required fields');

        $cardPayment = $this->getBuilder()
            ->setAttribute('currency', '')
            ->build(ConfigHelper::getConfig());

        $cardPayment->create();
    }

    public function testPaymentWithUnknownCurrency()
    {
        $cardPayment = $this->getBuilder()
            ->setAttribute('currency', 'ZZZ')
            ->build(ConfigHelper::getConfig());

        try {
            $cardPayment->create();
        } catch (\Exception $e) {
            AssertionHelper::assertApiExceptionWithModelErrors($e, 2, 1);

            return;
        }

        $this->fail('An expected ApiException has not been raised.');
    }

    public function testPaymentWithoutReference()
    {
        $this->setExpectedException('\Judopay\Exception\ValidationError', 'Missing required fields');

        $cardPayment = $this->getBuilder()
            ->unsetAttribute('yourConsumerReference')
            ->build(ConfigHelper::getConfig());

        $cardPayment->create();
    }

    public function testDuplicatePayment()
    {
        $cardPayment = $this->getBuilder()
            ->build(ConfigHelper::getConfig());
        $successfulResult = $cardPayment->create();

        try {
            $cardPayment->create();
        } catch (\Exception $e) {
            AssertionHelper::assertApiExceptionWithModelErrors($e, 0, 86, 409, 4);
            $this->assertContains($successfulResult['receiptId'], $e->getMessage());

            return;
        }

        $this->fail('An expected ApiException has not been raised.');
    }
}
