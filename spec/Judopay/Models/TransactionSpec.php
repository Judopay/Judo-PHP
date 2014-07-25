<?php

namespace spec\Judopay\Models;

require_once __DIR__.'/../../SpecHelper.php';

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Guzzle\Http\Client;

class TransactionSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Judopay\Models\Transaction');
    }

    public function it_should_list_all_transactions()
    {
        $this->configure();
		$this->setClient(
            \Judopay\SpecHelper::getMockResponseClient(
                200,
                'transactions/all.json'
            )
        );

		$output = $this->all();
        $output->shouldBeArray();
        $output['results'][0]['amount']->shouldEqual(1.01);
    }

    public function it_should_give_details_of_a_single_transaction_given_a_valid_receipt_id()
    {
        $this->configure();
        $this->setClient(
            \Judopay\SpecHelper::getMockResponseClient(
                200,
                'transactions/find.json'
            )
        );

        $receiptId = 439539;
        $output = $this->find($receiptId);
        $output->shouldBeArray();
        $output['receiptId']->shouldEqual((string)$receiptId);
    }

    protected function configure()
    {
        $configuration = new \Judopay\Configuration(array(
                'api_token' => 'token',
                'api_secret' => 'secret'
            )
        );

        $this->beConstructedWith($configuration);
    }
}
