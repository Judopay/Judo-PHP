<?php

namespace spec\Judopay\Model;

use Judopay\Model\Transaction;
use Judopay\Request;
use PHPUnit\Framework\Assert;

class TransactionSpec extends ModelObjectBehavior
{
    public function it_is_initializable()
    {
        $this->beConstructedWith(new Request($this->configuration));
        $this->shouldHaveType('Judopay\Model\Transaction');
    }

    public function it_should_list_all_transactions()
    {
        $request = $this->concoctRequest('transactions/all.json');
        $this->beConstructedWith($request);

        /** @var Transaction|TransactionSpec $this */
        $output = $this->all();
        $output->shouldBeArray();
        Assert::assertEquals(1.01, $output['results'][0]['amount']);
    }

    public function it_should_find_a_single_transaction()
    {
        $request = $this->concoctRequest('transactions/find.json');
        $this->beConstructedWith($request);

        $receiptId = 439539;
        /** @var Transaction|TransactionSpec $this */
        $output = $this->find($receiptId);
        $output->shouldBeArray();
        Assert::assertEquals($receiptId, $output['receiptId']);
    }
}
