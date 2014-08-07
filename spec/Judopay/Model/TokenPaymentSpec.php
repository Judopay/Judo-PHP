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
        $this->beConstructedWith($this->concoctRequest());

        $modelBuilder = new \Judopay\Test\TokenPaymentBuilder;
        $this->setAttributeValues(
            $modelBuilder->getAttributeValues()
        );
        $output = $this->create();

        $output->shouldBeArray();
        $output['result']->shouldEqual('Success');
    }

    public function it_should_raise_an_error_when_required_fields_are_missing()
    {
        $this->beConstructedWith($this->concoctRequest());
        $this->shouldThrow('\Judopay\Exception\ValidationError')->during('create');
    }

    protected function concoctRequest()
    {
        $request = new \Judopay\Request($this->configuration);
        $request->setClient(
            \Judopay\SpecHelper::getMockResponseClient(
                200,
                'card_payments/create.json'
            )
        );

        return $request;
    }
}