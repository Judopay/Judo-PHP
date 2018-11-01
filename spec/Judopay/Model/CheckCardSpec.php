<?php

namespace spec\Judopay\Model;

use Judopay\Model\CheckCard;
use Judopay\Request;
use Tests\Builders\CheckCardBuilder;

class CheckCardSpec extends ModelObjectBehavior
{
    public function it_is_initializable()
    {
        $this->beConstructedWith(new Request($this->configuration));
        $this->shouldHaveType('Judopay\Model\CheckCard');
    }

    public function it_should_save_new_card()
    {
        $this->beConstructedWith(
            $this->concoctRequest('transactions/check_card.json')
        );

        $modelBuilder = new CheckCardBuilder();
        /** @var CheckCard|CheckCardSpec $this */
        $this->setAttributeValues(
            $modelBuilder->compile()->getAttributeValues()
        );

        $output = $this->create();

        $output->shouldBeArray();
        $output['result']->shouldEqual('Success');
        $output['type']->shouldEqual('CheckCard');
        $output['amount']->shouldEqual("0.00");
    }
}
