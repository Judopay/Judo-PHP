<?php

namespace spec\Judopay\Model;

use Judopay\Model\CardPreauth;
use Tests\Builders\CardPaymentBuilder;

class CardPreauthSpec extends ModelObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Judopay\Model\CardPreauth');
    }

    public function it_should_create_a_new_preauth()
    {
        $this->beConstructedWith(
            $this->concoctRequest('card_payments/create.json')
        );

        $modelBuilder = new CardPaymentBuilder();
        /** @var CardPreauth|CardPreauthSpec $this */
        $this->setAttributeValues(
            $modelBuilder->compile()->getAttributeValues()
        );
        $output = $this->create();

        $output->shouldBeArray();
        $output['result']->shouldEqual('Success');
    }
}
