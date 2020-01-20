<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Tests\Builders\CardPaymentBuilder;
use Tests\Builders\CompleteThreeDBuilder;
use Tests\Helpers\AssertionHelper;
use Tests\Helpers\ConfigHelper;
use Judopay\Exception\ApiException as ApiException;

class ThreeDSecureTest extends TestCase
{
    protected function getBuilder()
    {
        return new CompleteThreeDBuilder();
    }

    protected function getPaymentBuilder()
    {
        return new CardPaymentBuilder();
    }

    public function testUpdateThreeDSecurePayment()
    {
        // Build a regular payment
        $cardPayment = $this->getPaymentBuilder()
            ->setType(CardPaymentBuilder::THREEDS_VISA_CARD)
            ->build(ConfigHelper::getConfig());

        // Process the payment
        $paymentResult = $cardPayment->create();

        // We should have a 3DS required message
        AssertionHelper::assertRequiresThreeDSecure($paymentResult);

        // Build the 3DS request
        $threeDSecureCompletion = $this->getBuilder()
            ->setAttribute('ReceiptId', $paymentResult['receiptId'])
            ->setAttribute('MD', $paymentResult['md'])
            ->setAttribute('PaRes', "paResReturnedByTheAcsUrl") // The ACS URL needs to be visited by the consumer
            ->build(ConfigHelper::getConfig());

        // Update the existing payment with a PUT
        $threeDSecureResult = $threeDSecureCompletion->update();

        // The payment has a successful status
        AssertionHelper::assertSuccessfulPayment($threeDSecureResult);
    }

    public function testUpdateWrongThreeDSecurePayment()
    {
        // Build the 3DS request for a Receipt not linked to this account
        $threeDSecureCompletion = $this->getBuilder()
            ->setAttribute('ReceiptId', "536586810336354304")
            ->setAttribute('MD', "200120164510412101100951")
            ->setAttribute('PaRes', "paResReturnedByTheAcsUrl") // The ACS URL needs to be visited by the consumer
            ->build(ConfigHelper::getConfig());

        try {
            // Update the existing payment with a PUT
            $threeDSecureResult = $threeDSecureCompletion->update();
        } catch (\Exception $e) {
            AssertionHelper::assertApiExceptionWithModelErrors(
                $e,
                0,
                72,
                409,
                ApiException::CATEGORY_PROCESSING);

            return;
        }

        $this->fail('An expected ApiException has not been raised.');
    }
}
