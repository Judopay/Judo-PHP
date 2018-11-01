<?php

namespace spec\Judopay\Model;

use Judopay\Model\SaveCard;
use Judopay\Request;
use Tests\Builders\SaveCardBuilder;

class SaveCardSpec extends ModelObjectBehavior
{
    public function it_is_initializable()
    {
        $this->beConstructedWith(new Request($this->configuration));
        $this->shouldHaveType('Judopay\Model\SaveCard');
    }

    public function it_should_save_new_card()
    {
        $this->beConstructedWith(
            $this->concoctRequest('transactions/save_card.json')
        );

        $modelBuilder = new SaveCardBuilder();
        /** @var SaveCard|SaveCardSpec $this */
        $this->setAttributeValues(
            $modelBuilder->compile()->getAttributeValues()
        );

        $output = $this->create();

        $output->shouldBeArray();
        $output['result']->shouldEqual('Success');
        $output['type']->shouldEqual('Register');
    }
}
