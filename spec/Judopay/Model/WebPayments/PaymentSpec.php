<?php

namespace spec\Judopay\Model\WebPayments;

use Judopay\Model\WebPayments\Payment;
use Judopay\Request;
use spec\Judopay\Model\ModelObjectBehavior;
use Tests\Builders\WebPayments\PaymentBuilder;

class PaymentSpec extends ModelObjectBehavior
{
    public function it_is_initializable()
    {
        $this->beConstructedWith(new Request($this->configuration));
        $this->shouldHaveType('Judopay\Model\WebPayments\Payment');
    }

    public function it_should_create_a_new_payment()
    {
        $this->beConstructedWith(
            $this->concoctRequest('web_payments/payments/create.json')
        );

        $modelBuilder = new PaymentBuilder();
        /** @var Payment|PaymentSpec $this */
        $this->setAttributeValues(
            $modelBuilder->compile()->getAttributeValues()
        );
        $output = $this->create();

        $output->shouldBeArray();
        $output['postUrl']->shouldBeLike('https://pay.judopay-sandbox.com/');
    }
}
