<?php

namespace spec\Judopay\Model;

use Judopay\Model\TokenPreauth;
use Tests\Builders\TokenPaymentBuilder;

class TokenPreauthSpec extends ModelObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Judopay\Model\TokenPreauth');
    }

    public function it_should_create_a_new_payment()
    {
        $this->beConstructedWith(
            $this->concoctRequest('card_payments/create.json')
        );

        $modelBuilder = new TokenPaymentBuilder();
        /** @var TokenPreauth|TokenPreauthSpec $this */
        $this->setAttributeValues(
            $modelBuilder->compile()->getAttributeValues()
        );
        $output = $this->create();

        $output->shouldBeArray();
        $output['result']->shouldEqual('Success');
    }
}
