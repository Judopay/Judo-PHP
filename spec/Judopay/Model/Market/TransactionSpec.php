<?php

namespace spec\Judopay\Model\Market;

require_once __DIR__.'/../ModelObjectBehavior.php';

class TransactionSpec extends \spec\Judopay\Model\ModelObjectBehavior
{
    public function it_is_initializable()
    {
        $this->beConstructedWith(new \Judopay\Request($this->configuration));
        $this->shouldHaveType('Judopay\Model\Market\Transaction');
    }

    public function it_should_list_all_transactions()
    {
        $request = $this->concoctRequest('transactions/all.json');
        $this->beConstructedWith($request);

        $output = $this->all();
        $output->shouldBeArray();
        $output['results'][0]['amount']->shouldEqual(1.01);
    }
}