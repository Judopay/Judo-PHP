<?php

namespace spec\Judopay\Model;

use Judopay\Model\Refund;
use PHPUnit\Framework\Assert;
use Tests\Builders\RefundBuilder;

class RefundSpec extends ModelObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Judopay\Model\Refund');
    }

    public function it_should_create_a_new_refund()
    {
        $this->beConstructedWith(
            $this->concoctRequest('card_payments/create.json')
        );

        $modelBuilder = new RefundBuilder();
        /** @var Refund|RefundSpec $this */
        $this->setAttributeValues(
            $modelBuilder->compile()->getAttributeValues()
        );
        $output = $this->create();

        $output->shouldBeArray();
        Assert::assertEquals('Success', $output['result']);
    }

    public function it_should_list_all_refunds()
    {
        $this->beConstructedWith(
            $this->concoctRequest('transactions/all.json')
        );

        /** @var Refund|RefundSpec $this */
        $output = $this->all();
        $output->shouldBeArray();
        Assert::assertEquals(1.01, $output['results'][0]['amount']);
    }
}
