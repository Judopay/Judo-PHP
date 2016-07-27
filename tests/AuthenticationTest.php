<?php
/**
 * @author Oleg Fetisov <ofetisov@corevalue.net>
 */

use PHPUnit\Framework\TestCase;
use Tests\Builders\CardPaymentBuilder;
use Tests\Helpers\AssertionHelper;
use Tests\Helpers\ConfigHelper;

class AuthenticationTest extends TestCase
{
    public function testPaymentWithInvalidJudoId()
    {
        $config = ConfigHelper::getConfig();

        $builder = new CardPaymentBuilder();
        $builder->setJudoId('123');
        $cardPayment = $builder->build($config);

        try {
            $cardPayment->create();
        } catch (\Exception $e) {
            AssertionHelper::assertApiExceptionWithModelErrors($e, 1, 1);

            return;
        }

        $this->fail('An expected ApiException has not been raised.');
    }

    public function testPaymentWithInvalidToken()
    {
        $config = ConfigHelper::getConfig(['apiToken' => 'Bad_token']);

        $builder = new CardPaymentBuilder();
        $cardPayment = $builder->build($config);

        try {
            $cardPayment->create();
        } catch (\Exception $e) {
            AssertionHelper::assertApiExceptionWithModelErrors($e, 0, 403, 403, 1);

            return;
        }

        $this->fail('An expected ApiException has not been raised.');
    }

    public function testPaymentWithInvalidSecret()
    {
        $config = ConfigHelper::getConfig(['apiSecret' => 'Bad_secret']);

        $builder = new CardPaymentBuilder();
        $cardPayment = $builder->build($config);

        try {
            $cardPayment->create();
        } catch (\Exception $e) {
            AssertionHelper::assertApiExceptionWithModelErrors($e, 0, 403, 403, 1);

            return;
        }

        $this->fail('An expected ApiException has not been raised.');
    }
}
