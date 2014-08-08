<?php

namespace spec\Judopay\Model;

require_once 'ModelObjectBehavior.php';

class TokenPaymentSpec extends ModelObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Judopay\Model\TokenPayment');
    }

    public function it_should_create_a_new_payment()
    {
        $this->beConstructedWith($this->concoctRequest('card_payments/create.json'));

        $modelBuilder = new \Judopay\Test\TokenPaymentBuilder;
        $this->setAttributeValues(
            $modelBuilder->getAttributeValues()
        );
        $output = $this->create();

        $output->shouldBeArray();
        $output['result']->shouldEqual('Success');
    }
}