<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Tests\Builders\CardPaymentBuilder;
use Tests\Builders\CompleteThreeDSecureBuilder;
use Tests\Helpers\AssertionHelper;
use Tests\Helpers\ConfigHelper;
use Judopay\Exception\ApiException as ApiException;

class ThreeDSecureTest extends TestCase
{
    protected function getBuilder()
    {
        return new CompleteThreeDSecureBuilder();
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
            ->build(ConfigHelper::getBaseConfig());

        // Process the payment
        $paymentResult = $cardPayment->create();

        // We should have a 3DS required message
        AssertionHelper::assertRequiresThreeDSecure($paymentResult);

        // Build the 3DS request
        $threeDSecureCompletion = $this->getBuilder()
            ->setAttribute('receiptId', $paymentResult['receiptId'])
            ->setAttribute('md', $paymentResult['md'])
            ->setAttribute('paRes', "paResReturnedByTheAcsUrl") // The ACS URL needs to be visited by the consumer
            ->build(ConfigHelper::getBaseConfig());

        // Update the existing payment with a PUT
        $threeDSecureResult = $threeDSecureCompletion->update();

        // The payment has a declined status because the PaRes is not the correct one
        AssertionHelper::assertDeclinedPayment($threeDSecureResult);
    }

    public function testUpdateWrongThreeDSecurePayment()
    {
        // Build the 3DS request for a Receipt not linked to this account
        $threeDSecureCompletion = $this->getBuilder()
            ->setAttribute('receiptId', "536586810336354304")
            ->setAttribute('md', "200120164510412101100951")
            ->setAttribute('paRes', "paResReturnedByTheAcsUrl") // The ACS URL needs to be visited by the consumer
            ->build(ConfigHelper::getBaseConfig());

        try {
            // Update the existing payment with a PUT
            $threeDSecureResult = $threeDSecureCompletion->update();
        } catch (\Exception $e) {
            AssertionHelper::assertApiExceptionWithModelErrors(
                $e,
                0,
                72,
                409,
                ApiException::CATEGORY_PROCESSING
            );

            return;
        }

        $this->fail('An expected ApiException has not been raised.');
    }
}
