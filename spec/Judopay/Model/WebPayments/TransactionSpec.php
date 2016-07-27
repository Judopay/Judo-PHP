<?php

namespace spec\Judopay\Model\WebPayments;

use Judopay\Model\Market\Transaction;
use Judopay\Request;
use spec\Judopay\Model\ModelObjectBehavior;

class TransactionSpec extends ModelObjectBehavior
{
    public function it_is_initializable()
    {
        $this->beConstructedWith(new Request($this->configuration));
        $this->shouldHaveType('Judopay\Model\WebPayments\Transaction');
    }

    public function it_should_find_a_single_transaction()
    {
        $request = $this->concoctRequest('web_payments/payments/find.json');
        $this->beConstructedWith($request);

        $reference
            = '4gcBAAMAGAASAAAADA66kRor6ofknGqU3A6i-759FprFGPH3ecVcW5ChMQK0f3pLBQ';
        /** @var Transaction|TransactionSpec $this */
        $output = $this->find($reference);
        $output->shouldBeArray();
        $output['reference']->shouldEqual($reference);
    }
}
