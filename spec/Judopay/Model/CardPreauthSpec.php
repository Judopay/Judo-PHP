<?php

namespace spec\Judopay\Model;

require_once 'ModelObjectBehavior.php';

class CardPreauthSpec extends ModelObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Judopay\Model\CardPreauth');
    }

    public function it_should_create_a_new_preauth()
    {
        $this->beConstructedWith($this->concoctRequest());

        $modelBuilder = new \Judopay\Test\CardPaymentBuilder;
        $this->setAttributeValues(
            $modelBuilder->getAttributeValues()
        );
        $output = $this->create();

        $output->shouldBeArray();
        $output['result']->shouldEqual('Success');
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