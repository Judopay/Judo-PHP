<?php

namespace Tests\Base;

use PHPUnit\Framework\TestCase;
use Tests\Builders\CardPaymentBuilder;
use Tests\Builders\CardPreauthBuilder;
use Tests\Helpers\AssertionHelper;
use Tests\Helpers\ConfigHelper;

abstract class PaymentTests extends TestCase
{
    /**
     * @return CardPaymentBuilder|CardPreauthBuilder
     */
    abstract protected function getBuilder();

    public function testValidPayment()
    {
        $cardPayment = $this->getBuilder()
            ->build(ConfigHelper::getBaseConfig());
        $result = $cardPayment->create();

        AssertionHelper::assertSuccessfulPayment($result);
        AssertionHelper::assertAuthCodeAvailable($result);
    }

    public function testDeclinedPayment()
    {
        $cardPayment = $this->getBuilder()
            ->setType(CardPaymentBuilder::INVALID_VISA_CARD)
            ->build(ConfigHelper::getBaseConfig());
        $result = $cardPayment->create();

        AssertionHelper::assertDeclinedPayment($result);
    }

    public function testPaymentWithNegativeAmount()
    {
        $cardPayment = $this->getBuilder()
            ->setAttribute('amount', -1)
            ->build(ConfigHelper::getBaseConfig());

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
            ->build(ConfigHelper::getBaseConfig());

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
            ->build(ConfigHelper::getBaseConfig());

        $cardPayment->create();
    }

    public function testPaymentWithUnknownCurrency()
    {
        $cardPayment = $this->getBuilder()
            ->setAttribute('currency', 'ZZZ')
            ->build(ConfigHelper::getBaseConfig());

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
            ->build(ConfigHelper::getBaseConfig());

        $cardPayment->create();
    }

    public function testDuplicatePayment()
    {
        $cardPayment = $this->getBuilder()
            ->build(ConfigHelper::getBaseConfig());
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

    public function testPrimaryAccountDetailsPayment()
    {
        $primaryAccountDetails = array(
            'name'          => 'John Smith',
            'accountNumber' => '123456',
            'dateOfBirth'   => '1980-01-01',
            'postCode'      => 'EC2A 4DP',
        );

        $cardPayment = $this->getBuilder()
            ->setAttribute('primaryAccountDetails', $primaryAccountDetails)
            ->build(ConfigHelper::getCybersourceConfig());
        $result = $cardPayment->create();

        AssertionHelper::assertSuccessfulPayment($result);
    }

    public function testPaymentWithAddress()
    {
        $address1 = "My house";
        $address2 = "My street";
        $address3 = "My area";
        $town = "My town";
        $postCode = "AB1 2CD";
        $countryCode = 826;
        $cardAddress = array(
            'address1'    => $address1,
            'address2'    => $address2,
            'address3'    => $address3,
            'town'        => $town,
            "postCode"    => $postCode,
            "countryCode" => $countryCode
        );

        $checkCard = $this->getBuilder()
            ->setAttribute('cardAddress', $cardAddress)
            ->build(ConfigHelper::getCybersourceConfig());

        $result = $checkCard->create();

        AssertionHelper::assertSuccessfulPayment($result);
        $returnedBillingAddress = $result['billingAddress'];
        $this->assertEquals($address1, $returnedBillingAddress['address1']);
        $this->assertEquals($address2, $returnedBillingAddress['address2']);
        $this->assertEquals($address3, $returnedBillingAddress['address3']);
        $this->assertEquals($town, $returnedBillingAddress['town']);
        $this->assertEquals($postCode, $returnedBillingAddress['postCode']);
        $this->assertEquals($countryCode, $returnedBillingAddress['countryCode']);
    }
}
