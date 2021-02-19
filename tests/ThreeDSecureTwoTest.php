<?php

namespace Tests;

use GuzzleHttp\Exception\BadResponseException;
use Judopay\Exception\ApiException;
use Judopay\Exception\ValidationError;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_Assert as Assert;
use Tests\Builders\CardPaymentBuilder;
use Tests\Builders\CompleteThreeDSecureTwoBuilder;
use Tests\Builders\ResumeThreeDSecureTwoBuilder;
use Tests\Helpers\AssertionHelper;
use Tests\Helpers\ConfigHelper;

class ThreeDSecureTwoTest extends TestCase
{
    protected function getPaymentBuilder()
    {
        return new CardPaymentBuilder();
    }

    protected function getResumeThreeDSecureTwoBuilder($receiptId)
    {
        return new ResumeThreeDSecureTwoBuilder($receiptId);
    }

    protected function getCompleteThreeDSecureTwoBuilder($receiptId)
    {
        return new CompleteThreeDSecureTwoBuilder($receiptId);
    }

    public function testPaymentWithThreedSecureTwoInvalidAuthenticationSource()
    {
        // Build a threeDSecureTwo payment with an invalid attribute
        $threeDSecureTwo = array(
            'authenticationSource'      => "invalid",
            'methodNotificationUrl'     => "https://www.test.com",
            'challengeNotificationUrl'  => "https://www.test.com",
            'methodCompletion'          => "No"
        );

        try {
            $cardPayment = $this->getPaymentBuilder()
                ->setType(CardPaymentBuilder::THREEDSTWO_VISA_CARD)
                ->setThreeDSecureTwoFields($threeDSecureTwo)
                ->build(ConfigHelper::getSafeChargeConfig());

            $this->fail('An expected ValidationError has not been raised.'); // We do not expect any other exception
        } catch (ValidationError $e) {
            Assert::assertNotNull($e); // We expect a validation error due to the invalid parameters
        } catch (\Exception $e) {
            $this->fail('An expected ValidationError has not been raised.'); // We do not expect any other exception
        }
    }

    public function testPaymentWithThreedSecureTwoInvalidMethodCompletion()
    {
        // Build a threeDSecureTwo payment with an invalid attribute
        $threeDSecureTwo = array(
            'authenticationSource'      => "Browser",
            'methodNotificationUrl'     => "https://www.test.com",
            'challengeNotificationUrl'  => "https://www.test.com",
            'methodCompletion'          => "invalid"
        );

        try {
            $cardPayment = $this->getPaymentBuilder()
                ->setType(CardPaymentBuilder::THREEDSTWO_VISA_CARD)
                ->setThreeDSecureTwoFields($threeDSecureTwo)
                ->build(ConfigHelper::getSafeChargeConfig());

            $this->fail('An expected ValidationError has not been raised.'); // We do not expect any other exception
        } catch (ValidationError $e) {
            Assert::assertNotNull($e); // We expect a validation error due to the invalid parameters
        } catch (\Exception $e) {
            $this->fail('An expected ValidationError has not been raised.'); // We do not expect any other exception
        }
    }

    public function testPaymentWithThreedSecureTwoRequiresDeviceDetailsCheck()
    {
        // Build a threeDSecureTwo payment
        $threeDSecureTwo = array(
            'authenticationSource' => "Browser",
            'methodNotificationUrl' => "https://www.test.com",
            'challengeNotificationUrl' => "https://www.test.com"
        );

        $cardPayment = $this->getPaymentBuilder()
            ->setType(CardPaymentBuilder::THREEDSTWO_VISA_CARD)
            ->setThreeDSecureTwoFields($threeDSecureTwo)
            ->build(ConfigHelper::getSafeChargeConfig());

        $paymentResult = [];

        try {
            $paymentResult = $cardPayment->create();
        } catch (BadResponseException $e) {
            $this->fail('The request was expected to be successful.'); // We do not expect any exception
        }

        // We should have received a request for additional device data gathering
        AssertionHelper::assertRequiresThreeDSecureTwoDeviceDetails($paymentResult);
    }

    public function testPaymentWithThreedSecureTwoResumeTransaction()
    {
        // Build a threeDSecureTwo payment
        $threeDSecureTwo = array(
            'authenticationSource'      => "Browser",
            'methodNotificationUrl'     => "https://www.test.com",
            'challengeNotificationUrl'  => "https://www.test.com"
        );

        $cardPayment = $this->getPaymentBuilder()
            ->setType(CardPaymentBuilder::THREEDSTWO_VISA_CARD)
            ->setThreeDSecureTwoFields($threeDSecureTwo)
            ->build(ConfigHelper::getSafeChargeConfig());

        $paymentResult = [];

        try {
            $paymentResult = $cardPayment->create();
        } catch (BadResponseException $e) {
            $this->fail('The request was expected to be successful.'); // We do not expect any exception
        }

        // We should have received a request for additional device data gathering
        AssertionHelper::assertRequiresThreeDSecureTwoDeviceDetails($paymentResult);

        // Build the Resume3d request for the payment after its device gathering happened
        // Build a threeDSecureTwo payment
        $threeDSecureTwo = array(
            'authenticationSource'      => "Browser",
            'methodCompletion'          => "Yes"
        );

        $resumeThreeDSecureTwo = $this->getResumeThreeDSecureTwoBuilder($paymentResult['receiptId'])
            ->setCv2($cardPayment->getAttributeValue('cv2')) // Resending the cv2 as it it not saved
            ->setThreeDSecureTwoFields($threeDSecureTwo)
            ->build(ConfigHelper::getSafeChargeConfig());

        Assert::assertNotNull($resumeThreeDSecureTwo);

        $resumeResult = [];

        try {
            $resumeResult = $resumeThreeDSecureTwo->update();
        } catch (BadResponseException $e) {
            $this->fail('The request was expected to be successful.'); // We do not expect any exception
        }

        // We should have received a request for additional device data gathering
        AssertionHelper::assertRequiresThreeDSecureTwoChallengeCompletion($resumeResult);
    }

    /*
     * This cannot run as a full automated test because of a step involving a web browser
     */
    public function testPaymentWithThreedSecureTwoCompleteTransaction()
    {
        // Build the Complete3d request for the payment after its ACS challenge happened
        $completeThreeDSecureTwo = $this->getCompleteThreeDSecureTwoBuilder('12345678')
            ->setCv2('123')
            ->setVersion('2.1.0')
            ->build(ConfigHelper::getSafeChargeConfig());

        Assert::assertNotNull($completeThreeDSecureTwo);

        $completeResult = null;

        try {
            $completeResult = $completeThreeDSecureTwo->update();
            $this->fail('The request was expected to fail due to a non existing referenced payment.');
        } catch (ApiException $e) {
            // The payment is expected to fail since no transaction exists under this receipt ID
            Assert::assertEquals("Sorry, but the transaction specified was not found.", $e->getMessage());
        }

        // We should have received a request for additional device data gathering
        Assert::assertNull($completeResult);
    }
}
