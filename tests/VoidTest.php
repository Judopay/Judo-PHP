<?php

namespace Tests\Base;

use PHPUnit_Framework_TestCase;
use Tests\Builders\CardPaymentBuilder;
use Tests\Builders\CardPreauthBuilder;
use Tests\Builders\VoidBuilder;
use Tests\Helpers\AssertionHelper;
use Tests\Helpers\ConfigHelper;

class VoidTest extends PHPUnit_Framework_TestCase
{
    protected function makePreauthPayment($preauth = true)
    {
        $builder = $preauth
            ? new CardPreauthBuilder()
            : new CardPaymentBuilder();

        $payment = $builder->build(ConfigHelper::getConfig())
            ->create();

        AssertionHelper::assertSuccessfulPayment($payment);

        return $payment['receiptId'];
    }

    public function testValidPreauthVoid()
    {
        $receiptId = $this->makePreauthPayment();
        $builder = new VoidBuilder($receiptId);

        $result = $builder->build(ConfigHelper::getConfig())
            ->create();

        AssertionHelper::assertSuccessfulPayment($result);
    }

    public function testDeclinedPaymentVoid()
    {
        $receiptId = $this->makePreauthPayment(false);
        $builder = new VoidBuilder($receiptId);

        try {
            $builder->build(ConfigHelper::getConfig())
                ->create();
        } catch (\Exception $e) {
            AssertionHelper::assertApiExceptionWithModelErrors($e, 0, 50, 404);

            return;
        }

        $this->fail('An expected ApiException has not been raised.');
    }

    public function testWrongReceiptId()
    {
        $builder = new VoidBuilder();

        try {
            $builder->build(ConfigHelper::getConfig())
                ->create();
        } catch (\Exception $e) {
            AssertionHelper::assertApiExceptionWithModelErrors($e, 1, 1);

            return;
        }

        $this->fail('An expected ApiException has not been raised.');
    }

    public function testDoubleVoid()
    {
        $receiptId = $this->makePreauthPayment();
        $builder = new VoidBuilder($receiptId);

        $void = $builder->build(ConfigHelper::getConfig());

        AssertionHelper::assertSuccessfulPayment($void->create());

        try {
            $builder->build(ConfigHelper::getConfig())->create();
        } catch (\Exception $e) {
            AssertionHelper::assertApiExceptionWithModelErrors($e, 0, 51);

            return;
        }

        $this->fail('An expected ApiException has not been raised.');
    }

    public function testVoidWithInvalidAmount()
    {
        $receiptId = $this->makePreauthPayment();
        $builder = new VoidBuilder($receiptId);

        $void = $builder->setAttribute('amount', 100)
            ->build(ConfigHelper::getConfig());

        try {
            $void->create();
        } catch (\Exception $e) {
            AssertionHelper::assertApiExceptionWithModelErrors($e, 0, 53, 404);

            return;
        }

        $this->fail('An expected ApiException has not been raised.');
    }
}
