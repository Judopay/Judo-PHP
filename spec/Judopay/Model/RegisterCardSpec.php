<?php

namespace spec\Judopay\Model;

use Judopay\Model\SaveCard;
use Judopay\Request;
use Tests\Builders\RegisterCardBuilder;

class RegisterCardSpec extends ModelObjectBehavior
{
    public function it_is_initializable()
    {
        $this->beConstructedWith(new Request($this->configuration));
        $this->shouldHaveType('Judopay\Model\RegisterCard');
    }

    public function it_should_save_new_card()
    {
        $this->beConstructedWith(
            $this->concoctRequest('transactions/register_card.json')
        );

        $modelBuilder = new RegisterCardBuilder();
        /** @var SaveCard|SaveCardSpec $this */
        $this->setAttributeValues(
            $modelBuilder->compile()->getAttributeValues()
        );

        $output = $this->create();

        $output->shouldBeArray();
        $output['result']->shouldEqual('Success');
        $output['type']->shouldEqual('PreAuth');
        $output['amount']->shouldEqual("1.01");
    }
}
