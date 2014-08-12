<?php

namespace spec\Judopay\Model\WebPayments;

require_once __DIR__.'/../ModelObjectBehavior.php';

class TransactionSpec extends \spec\Judopay\Model\ModelObjectBehavior
{
    public function it_is_initializable()
    {
        $this->beConstructedWith(new \Judopay\Request($this->configuration));
        $this->shouldHaveType('Judopay\Model\WebPayments\Transaction');
    }

    public function it_should_find_a_single_transaction()
    {
        $request = $this->concoctRequest('web_payments/payments/find.json');
        $this->beConstructedWith($request);

        $reference = '4gcBAAMAGAASAAAADA66kRor6ofknGqU3A6i-759FprFGPH3ecVcW5ChMQK0f3pLBQ';
        $output = $this->find($reference);
        $output->shouldBeArray();
        $output['reference']->shouldEqual($reference);        
    }
}