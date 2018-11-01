<?php

namespace spec\Judopay\Model\Market;

use Judopay\Model\Market\Collection;
use spec\Judopay\Model\ModelObjectBehavior;
use Tests\Builders\RefundBuilder;

class CollectionSpec extends ModelObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Judopay\Model\Market\Collection');
    }

    public function it_should_create_a_new_collection()
    {
        $this->beConstructedWith(
            $this->concoctRequest('card_payments/create.json')
        );

        $modelBuilder = new RefundBuilder();
        /** @var Collection|CollectionSpec $this */
        $this->setAttributeValues(
            $modelBuilder->compile()->getAttributeValues()
        );
        $output = $this->create();

        $output->shouldBeArray();
        $output['result']->shouldEqual('Success');
    }

    public function it_should_list_all_collections()
    {
        $this->beConstructedWith(
            $this->concoctRequest('transactions/all.json')
        );

        /** @var Collection|CollectionSpec $this */
        $output = $this->all();
        $output->shouldBeArray();
        $output['results'][0]['amount']->shouldEqual(1.01);
    }
}
