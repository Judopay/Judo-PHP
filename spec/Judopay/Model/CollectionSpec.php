<?php

namespace spec\Judopay\Model;

use Judopay\Model\Collection;
use Tests\Builders\CardPaymentBuilder;
use Tests\Builders\GetTransactionBuilder;
use Tests\Builders\RefundBuilder;

class CollectionSpec extends ModelObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Judopay\Model\Collection');
    }

    public function it_should_create_a_new_collection()
    {
        // Mock of a POST
        $mockRequest = $this->concoctRequest('card_payments/create.json');
        $this->beConstructedWith($mockRequest);
        $modelBuilder = new RefundBuilder();

        $this->setAttributeValues(
            $modelBuilder->compile()->getAttributeValues()
        );
        $output = $this->create();

        $output->shouldBeArray();
        $output['result']->shouldEqual('Success');
    }

    public function it_should_list_all_collections()
    {
        // Mock of a GET
        $mockRequest = $this->concoctRequest('transactions/all.json');
        $this->beConstructedWith($mockRequest);
        $modelBuilder = new GetTransactionBuilder();

        /** @var Collection|CollectionSpec $this */
        $this->setAttributeValues(
            $modelBuilder->compile()->getAttributeValues()
        );

        /** @var Collection|CollectionSpec $this */
        $output = $this->all();

        $output->shouldBeArray();
        $output['results'][0]['amount']->shouldEqual(1.01);
    }
}
