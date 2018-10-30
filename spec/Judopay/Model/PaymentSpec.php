<?php

namespace spec\Judopay\Model;

use Judopay\Model\Payment;
use Judopay\Request;
use PHPUnit\Framework\Assert;

class PaymentSpec extends ModelObjectBehavior
{
    public function it_is_initializable()
    {
        $this->beConstructedWith(new Request($this->configuration));
        $this->shouldHaveType('Judopay\Model\Payment');
    }

    public function it_should_list_all_transactions()
    {
        $request = $this->concoctRequest('transactions/all.json');
        $this->beConstructedWith($request);

        /** @var Payment|PaymentSpec $this */
        $output = $this->all();
        $output->shouldBeArray();
        Assert::assertEquals(1.01, $output['results'][0]['amount']);

    }
}
