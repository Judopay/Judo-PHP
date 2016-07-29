<?php
/**
 * @author Oleg Fetisov <ofetisov@corevalue.net>
 */

namespace Tests;

use PHPUnit_Framework_TestCase;
use Tests\Builders\CardPaymentBuilder;
use Tests\Helpers\AssertionHelper;
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
        $config = ConfigHelper::getConfig();

        $builder = new CardPaymentBuilder();
        $builder->setAttribute('cv2', '');

        $cardPayment = $builder->build($config);

        try {
            $cardPayment->create();
        } catch (\Exception $e) {
            AssertionHelper::assertApiExceptionWithModelErrors($e, 1, 1);

            return;
        }

        $this->fail('An expected ApiException has not been raised.');
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
