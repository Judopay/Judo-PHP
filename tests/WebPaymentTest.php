<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Tests\Builders\CardPaymentBuilder;
use Tests\Builders\WebPayments\PaymentBuilder;
use Tests\Helpers\AssertionHelper;
use Tests\Helpers\ConfigHelper;

class WebPaymentTest extends TestCase
{
    protected function getBuilder()
    {
        return new PaymentBuilder();
    }

    public function testCreateWebPayment()
    {
        $webPaymentResult = $this->getBuilder()
            ->build(ConfigHelper::getBaseConfig())
            ->create();

        AssertionHelper::assertSuccessfulWebPaymentCreation($webPaymentResult);
    }

    public function testCompleteWebPaymentWithApiRequest()
    {
        $webPaymentResult = $this->getBuilder()
            ->build(ConfigHelper::getBaseConfig())
            ->create();

        AssertionHelper::assertSuccessfulWebPaymentCreation($webPaymentResult);

        $cardPaymentBuilder =  new CardPaymentBuilder();
        $cardPaymentBuilder->setAttribute("webPaymentReference", $webPaymentResult['reference']);

        $cardPayment = $cardPaymentBuilder->build(ConfigHelper::getBaseConfig())
            ->create();

        AssertionHelper::assertSuccessfulPayment($cardPayment);
    }
}
