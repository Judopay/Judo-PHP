<?php

namespace Tests;

use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Tests\Builders\CardPaymentBuilder;
use Tests\Builders\RefundBuilder;
use Tests\Helpers\AssertionHelper;
use Tests\Helpers\ConfigHelper;

class RefundTest extends TestCase
{
    protected function makePayment($amount = 1.02)
    {
        $builder = new CardPaymentBuilder($amount);

        $paymentResult = $builder->build(ConfigHelper::getBaseConfig())
            ->create();

        AssertionHelper::assertSuccessfulPayment($paymentResult);

        return $paymentResult['receiptId'];
    }

    public function testValidRefund()
    {
        $transactionAmount = 8.99;

        // Get the receipt for a successful transaction
        $receiptId = $this->makePayment($transactionAmount);

        // Prepare a refund for the payment
        $builder = new RefundBuilder(
            $receiptId,
            $transactionAmount
        );

        // Make the refund
        $refundResult = $builder->build(ConfigHelper::getBaseConfig())
            ->create();

        AssertionHelper::assertSuccessfulPayment($refundResult);
        Assert::assertEquals($transactionAmount, $refundResult['amount']);
    }
}
