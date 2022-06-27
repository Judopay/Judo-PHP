<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Tests\Builders\CardPaymentBuilder;
use Tests\Builders\CardPreauthBuilder;
use Tests\Builders\VoidTransactionBuilder;
use Tests\Helpers\AssertionHelper;
use Tests\Helpers\ConfigHelper;

class VoidTest extends TestCase
{
    protected function makePreauthPayment($preauth = true)
    {
        $builder = $preauth
            ? new CardPreauthBuilder()
            : new CardPaymentBuilder();

        $payment = $builder->build(ConfigHelper::getBaseConfig())
            ->create();

        AssertionHelper::assertSuccessfulPayment($payment);

        return $payment['receiptId'];
    }

    public function testValidPreauthVoid()
    {
        $receiptId = $this->makePreauthPayment();
        $builder = new VoidTransactionBuilder($receiptId);

        $result = $builder->build(ConfigHelper::getBaseConfig())
            ->create();

        AssertionHelper::assertSuccessfulPayment($result);
    }

    public function testDeclinedPaymentVoid()
    {
        $receiptId = $this->makePreauthPayment(false);
        $builder = new VoidTransactionBuilder($receiptId);

        try {
            $builder->build(ConfigHelper::getBaseConfig())
                ->create();
        } catch (\Exception $e) {
            AssertionHelper::assertApiExceptionWithModelErrors($e, 0, 50, 404);

            return;
        }

        $this->fail('An expected ApiException has not been raised.');
    }

    public function testWrongReceiptId()
    {
        $builder = new VoidTransactionBuilder();

        try {
            $builder->build(ConfigHelper::getBaseConfig())
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
        $builder = new VoidTransactionBuilder($receiptId);

        $void = $builder->build(ConfigHelper::getBaseConfig());

        AssertionHelper::assertSuccessfulPayment($void->create());

        try {
            $builder->build(ConfigHelper::getBaseConfig())->create();
        } catch (\Exception $e) {
            AssertionHelper::assertApiExceptionWithModelErrors($e, 0, 51);

            return;
        }

        $this->fail('An expected ApiException has not been raised.');
    }

    public function testVoidWithInvalidAmount()
    {
        $receiptId = $this->makePreauthPayment();
        $builder = new VoidTransactionBuilder($receiptId);

        $void = $builder->setAttribute('amount', 100)
            ->build(ConfigHelper::getBaseConfig());

        try {
            $void->create();
        } catch (\Exception $e) {
            AssertionHelper::assertApiExceptionWithModelErrors($e, 0, 53, 404);

            return;
        }

        $this->fail('An expected ApiException has not been raised.');
    }
}
