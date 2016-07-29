<?php
/**
 * @author Oleg Fetisov <ofetisov@corevalue.net>
 */

namespace Tests;

use PHPUnit_Framework_TestCase;
use Tests\Builders\CardPaymentBuilder;
use Tests\Builders\TokenPaymentBuilder;
use Tests\Helpers\AssertionHelper;
use Tests\Helpers\ConfigHelper;

class TokenPaymentTest extends PHPUnit_Framework_TestCase
{
    const CONSUMER_REFERENCE = '1234512345';
    protected $cardToken;
    protected $consumerToken;

    public function setUp()
    {
        $config = ConfigHelper::getConfig();

        $builder = new CardPaymentBuilder();
        $cardPayment = $builder->setAttribute('yourConsumerReference', self::CONSUMER_REFERENCE)
            ->build($config);

        $result = $cardPayment->create();

        AssertionHelper::assertSuccessfulPayment($result);

        $this->cardToken = $result['cardDetails']['cardToken'];
        $this->consumerToken = $result['consumer']['consumerToken'];
    }

    public function testValidTokenPayment()
    {
        $config = ConfigHelper::getConfig();

        $builder = new TokenPaymentBuilder(self::CONSUMER_REFERENCE, $this->consumerToken, $this->cardToken);
        $tokenPayment = $builder->build($config);
        $result = $tokenPayment->create();

        AssertionHelper::assertSuccessfulPayment($result);
    }

    public function testDeclinedTokenPayment()
    {
        $config = ConfigHelper::getConfig();

        $builder = new TokenPaymentBuilder(self::CONSUMER_REFERENCE, $this->consumerToken, $this->cardToken);
        $tokenPayment = $builder->setAttribute('cv2', '666')
            ->build($config);

        $result = $tokenPayment->create();

        AssertionHelper::assertDeclinedPayment($result);
    }

    public function testTokenPaymentAndWithoutToken()
    {
        $this->setExpectedException('\Judopay\Exception\ValidationError', 'Missing required fields');
        $config = ConfigHelper::getConfig();

        $builder = new TokenPaymentBuilder(self::CONSUMER_REFERENCE, '', $this->cardToken);
        $tokenPayment = $builder->build($config);

        $tokenPayment->create();
    }

    public function testTokenPaymentWithoutCv2AndWithoutToken()
    {
        $this->setExpectedException('\Judopay\Exception\ValidationError', 'Missing required fields');
        $config = ConfigHelper::getConfig();

        $builder = new TokenPaymentBuilder(self::CONSUMER_REFERENCE, '', $this->cardToken);
        $tokenPayment = $builder->unsetAttribute('cv2')
            ->build($config);

        $tokenPayment->create();
    }

    public function testTokenPaymentWithNegativeAmount()
    {
        $config = ConfigHelper::getConfig();

        $builder = new TokenPaymentBuilder(self::CONSUMER_REFERENCE, $this->consumerToken, $this->cardToken);
        $tokenPayment = $builder->setAttribute('amount', -1)
            ->build($config);

        try {
            $tokenPayment->create();
        } catch (\Exception $e) {
            AssertionHelper::assertApiExceptionWithModelErrors($e, 1, 1);

            return;
        }
    }

    public function testTokenPaymentWithZeroAmount()
    {
        $config = ConfigHelper::getConfig();

        $builder = new TokenPaymentBuilder(self::CONSUMER_REFERENCE, $this->consumerToken, $this->cardToken);
        $tokenPayment = $builder->setAttribute('amount', 0)
            ->build($config);

        try {
            $tokenPayment->create();
        } catch (\Exception $e) {
            AssertionHelper::assertApiExceptionWithModelErrors($e, 1, 1);

            return;
        }
    }

    public function testTokenPaymentWithoutCurrency()
    {
        $config = ConfigHelper::getConfig();

        $builder = new TokenPaymentBuilder(self::CONSUMER_REFERENCE, $this->consumerToken, $this->cardToken);
        $tokenPayment = $builder->unsetAttribute('currency')
            ->build($config);

        $result = $tokenPayment->create();

        AssertionHelper::assertSuccessfulPayment($result);
    }

    public function testTokenPaymentWithUnknownCurrency()
    {
        $config = ConfigHelper::getConfig();

        $builder = new TokenPaymentBuilder(self::CONSUMER_REFERENCE, $this->consumerToken, $this->cardToken);
        $tokenPayment = $builder->setAttribute('currency', 'ZZZ')
            ->build($config);

        $result = $tokenPayment->create();

        AssertionHelper::assertSuccessfulPayment($result);
    }

    public function testTokenPaymentWithoutReference()
    {
        $this->setExpectedException('\Judopay\Exception\ValidationError', 'Missing required fields');
        $config = ConfigHelper::getConfig();

        $builder = new TokenPaymentBuilder('', $this->consumerToken, $this->cardToken);
        $tokenPayment = $builder->build($config);

        $tokenPayment->create();
    }

    public function testDeclinedTokenPaymentWithoutCv2()
    {
        $config = ConfigHelper::getConfig();

        $builder = new TokenPaymentBuilder(self::CONSUMER_REFERENCE, $this->consumerToken, $this->cardToken);
        $tokenPayment = $builder->unsetAttribute('cv2')
            ->build($config);

        $result = $tokenPayment->create();

        AssertionHelper::assertDeclinedPayment($result);
    }

    public function testTokenPaymentWithoutCv2AndWithNegativeAmount()
    {
        $config = ConfigHelper::getConfig();

        $builder = new TokenPaymentBuilder(self::CONSUMER_REFERENCE, $this->consumerToken, $this->cardToken);
        $tokenPayment = $builder->setAttribute('amount', -1)
            ->unsetAttribute('cv2')
            ->build($config);

        try {
            $tokenPayment->create();
        } catch (\Exception $e) {
            AssertionHelper::assertApiExceptionWithModelErrors($e, 1, 1);

            return;
        }
    }

    public function testTokenPaymentWithoutCv2AndWithZeroAmount()
    {
        $config = ConfigHelper::getConfig();

        $builder = new TokenPaymentBuilder(self::CONSUMER_REFERENCE, $this->consumerToken, $this->cardToken);
        $tokenPayment = $builder->setAttribute('amount', 0)
            ->unsetAttribute('cv2')
            ->build($config);

        try {
            $tokenPayment->create();
        } catch (\Exception $e) {
            AssertionHelper::assertApiExceptionWithModelErrors($e, 1, 1);

            return;
        }
    }

    public function testTokenPaymentWithoutCv2AndWithoutCurrency()
    {
        $config = ConfigHelper::getConfig();

        $builder = new TokenPaymentBuilder(self::CONSUMER_REFERENCE, $this->consumerToken, $this->cardToken);
        $tokenPayment = $builder->unsetAttribute('currency')
            ->unsetAttribute('cv2')
            ->build($config);

        $result = $tokenPayment->create();

        AssertionHelper::assertDeclinedPayment($result);
    }

    public function testTokenPaymentWithoutCv2AndWithUnknownCurrency()
    {
        $config = ConfigHelper::getConfig();

        $builder = new TokenPaymentBuilder(self::CONSUMER_REFERENCE, $this->consumerToken, $this->cardToken);
        $tokenPayment = $builder->setAttribute('currency', 'ZZZ')
            ->unsetAttribute('cv2')
            ->build($config);

        $result = $tokenPayment->create();

        AssertionHelper::assertDeclinedPayment($result);
    }

    public function testTokenPaymentWithoutCv2AndWithoutReference()
    {
        $this->setExpectedException('\Judopay\Exception\ValidationError', 'Missing required fields');
        $config = ConfigHelper::getConfig();

        $builder = new TokenPaymentBuilder('', $this->consumerToken, $this->cardToken);
        $tokenPayment = $builder->unsetAttribute('cv2')
            ->build($config);

        $tokenPayment->create();
    }
}
