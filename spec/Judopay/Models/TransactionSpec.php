<?php

namespace spec\Judopay\Models;

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

        $plugin = new \Guzzle\Plugin\Mock\MockPlugin();
        $mockResponse = new \Guzzle\Http\Message\Response(200, null, 'banana');
        $plugin->addResponse($mockResponse);
        $client = new \Guzzle\Http\Client();
        $client->addSubscriber($plugin);

		$this->setClient($client);
		$this->all()->shouldReturn('banana');
    }
}


  // it 'should list all transactions' do
  //   stub_get('/transactions').
  //     to_return(:status => 200,
  //               :body => lambda { |_request| fixture('transactions/all.json') })

  //   transactions = Judopay::Transaction.all
  //   expect(transactions).to be_a(Hash)
  //   expect(transactions.results[0].amount).to equal(1.01)
  // end