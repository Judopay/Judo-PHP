<?php

namespace spec\Judopay\Model\WebPayments;

require_once __DIR__.'/../ModelObjectBehavior.php';

class PreauthSpec extends \spec\Judopay\Model\ModelObjectBehavior
{
    public function it_is_initializable()
    {
        $this->beConstructedWith(new \Judopay\Request($this->configuration));
        $this->shouldHaveType('Judopay\Model\WebPayments\Preauth');
    }

    public function it_should_create_a_new_payment()
    {
        $this->beConstructedWith($this->concoctRequest('web_payments/payments/create.json'));

        $modelBuilder = new \Judopay\Test\WebPayments\PaymentBuilder;
        $this->setAttributeValues(
            $modelBuilder->getAttributeValues()
        );
        $output = $this->create();

        $output->shouldBeArray();
        $output['postUrl']->shouldBeLike('https://pay.judopay-sandbox.com/');
    }
}