<?php

namespace spec\Judopay\Model;

use Judopay\Model\Collection;
use PHPUnit\Framework\Assert;
use Tests\Builders\RefundBuilder;

class CollectionSpec extends ModelObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Judopay\Model\Collection');
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
        Assert::assertEquals('Success', $output['result']);

    }

    public function it_should_list_all_collections()
    {
        $this->beConstructedWith(
            $this->concoctRequest('transactions/all.json')
        );

        /** @var Collection|CollectionSpec $this */
        $output = $this->all();
        $output->shouldBeArray();
        Assert::assertEquals(1.01, $output['results'][0]['amount']);
    }
}
