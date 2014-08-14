<?php

namespace spec\Judopay\Model\Market;

require_once __DIR__.'/../ModelObjectBehavior.php';

class CollectionSpec extends \spec\Judopay\Model\ModelObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Judopay\Model\Market\Collection');
    }

    public function it_should_create_a_new_collection()
    {
        $this->beConstructedWith($this->concoctRequest('card_payments/create.json'));

        $modelBuilder = new \Judopay\Test\RefundBuilder;
        $this->setAttributeValues(
            $modelBuilder->getAttributeValues()
        );
        $output = $this->create();

        $output->shouldBeArray();
        $output['result']->shouldEqual('Success');
    }

    public function it_should_list_all_collections()
    {
        $this->beConstructedWith($this->concoctRequest('transactions/all.json'));

        $output = $this->all();
        $output->shouldBeArray();
        $output['results'][0]['amount']->shouldEqual(1.01);
    }

}