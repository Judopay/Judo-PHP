<?php

namespace Tests;

use PHPUnit_Framework_TestCase;
use Tests\Builders\EncryptDetailsBuilder;
use Tests\Builders\OneUseTokenPaymentBuilder;
use Tests\Helpers\AssertionHelper;
use Tests\Helpers\ConfigHelper;

class AdditionsPaymentTest extends PHPUnit_Framework_TestCase
{

    public function testOneUseTokenPayment()
    {
        # Generate one use token
        $encryptionResult = $this->generateOneUseToken();
        $oneUseToken = $encryptionResult['oneUseToken'];
        $this->assertNotEmpty($oneUseToken);

        # Make successful payment with one use token
        $tokenPaymentResult = $this->makePaymentWithOneUseToken($oneUseToken);
        $this->assertEquals('Success', $tokenPaymentResult['result']);

        # Try and fail to make second payment with one use token
        try {
            $this->makePaymentWithOneUseToken($oneUseToken);
        } catch (\Exception $e) {
            AssertionHelper::assertApiExceptionWithModelErrors($e, 0, 153, 400, 1);
            return;
        }
        $this->fail('An expected ApiException has not been raised.');
    }

    protected function generateOneUseToken()
    {
        $encryptDetails = $this->encryptDetailsRequestBuilder()
            ->build(ConfigHelper::getConfig());
        return $encryptDetails->create();
    }

    protected function encryptDetailsRequestBuilder()
    {
        return new EncryptDetailsBuilder();
    }

    protected function makePaymentWithOneUseToken($token)
    {
        $tokenPayment = $this->tokenPaymentRequestBuilder()
            ->setAttribute('oneUseToken', $token)
            ->build(ConfigHelper::getConfig());
        return $tokenPayment->create();
    }

    protected function tokenPaymentRequestBuilder()
    {
        return new OneUseTokenPaymentBuilder();
    }
}
