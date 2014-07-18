<?php

namespace spec\Judopay\Models;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use GuzzleHttp\Client;
use GuzzleHttp\Subscriber\Mock;
use GuzzleHttp\Message\Response;

class TransactionSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Judopay\Models\Transaction');
    }

    public function it_should_list_all_transactions()
    {
		$client = new Client();

		// Create a mock subscriber and queue two responses.
		$mock = new Mock([
		    new Response(200, ['X-Foo' => 'Bar']),         // Use response object
		]);

		// Add the mock subscriber to the client.
		$client->getEmitter()->attach($mock);
		//$client->get('/')->getStatusCode()->shouldReturn(200);
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