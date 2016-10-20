<?php

namespace Tests;

use PHPUnit_Framework_TestCase;
use Tests\Builders\CardPaymentBuilder;
use Tests\Helpers\ConfigHelper;

class CardDetailsTest extends PHPUnit_Framework_TestCase
{
    public function testPaymentWithMissingCardNumber()
    {
        $this->setExpectedException('\Judopay\Exception\ValidationError', 'Missing required fields');

        $config = ConfigHelper::getConfig();

        $builder = new CardPaymentBuilder();
        $builder->setAttribute('cardNumber', '');

        $cardPayment = $builder->build($config);
        $cardPayment->create();
    }

    public function testPaymentWithMissingCv2()
    {
        $this->setExpectedException('\Judopay\Exception\ValidationError', 'Missing required fields');

        $config = ConfigHelper::getConfig();

        $builder = new CardPaymentBuilder();
        $builder->setAttribute('cv2', '');

        $cardPayment = $builder->build($config);

        $cardPayment->create();
    }

    public function testPaymentWithMissingExpiryDate()
    {
        $this->setExpectedException('\Judopay\Exception\ValidationError', 'Missing required fields');

        $config = ConfigHelper::getConfig();

        $builder = new CardPaymentBuilder();
        $builder->setAttribute('expiryDate', '');

        $cardPayment = $builder->build($config);
        $cardPayment->create();
    }
}
