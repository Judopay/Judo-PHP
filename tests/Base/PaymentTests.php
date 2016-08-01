<?php
/**
 * @author Oleg Fetisov <ofetisov@corevalue.net>
 */

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
        $config = ConfigHelper::getConfig();

        $cardPayment = $this->getBuilder()->build($config);
        $result = $cardPayment->create();

        AssertionHelper::assertSuccessfulPayment($result);
    }

    public function testDeclinedPayment()
    {
        $config = ConfigHelper::getConfig();

        $cardPayment = $this->getBuilder()
            ->setType(CardPaymentBuilder::INVALID_VISA_CARD)
            ->build($config);
        $result = $cardPayment->create();

        AssertionHelper::assertDeclinedPayment($result);
    }

    public function testPaymentWithNegativeAmount()
    {
        $config = ConfigHelper::getConfig();

        $cardPayment = $this->getBuilder()
            ->setAttribute('amount', -1)
            ->build($config);

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
        $config = ConfigHelper::getConfig();

        $cardPayment = $this->getBuilder()
            ->setAttribute('amount', 0)
            ->build($config);

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
        $config = ConfigHelper::getConfig();

        $cardPayment = $this->getBuilder()
            ->setAttribute('currency', '')
            ->build($config);

        $cardPayment->create();
    }

    public function testPaymentWithUnknownCurrency()
    {
        $config = ConfigHelper::getConfig();

        $cardPayment = $this->getBuilder()
            ->setAttribute('currency', 'ZZZ')
            ->build($config);

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
        $config = ConfigHelper::getConfig();

        $cardPayment = $this->getBuilder()
            ->setAttribute('yourConsumerReference', '')
            ->build($config);

        $cardPayment->create();
    }
}
