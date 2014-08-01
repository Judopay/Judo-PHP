<?php

namespace spec\Judopay\Model;

require_once __DIR__.'/../../SpecHelper.php';

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Guzzle\Http\Client;
use \Judopay\SpecHelper;

class TransactionSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(\Judopay\SpecHelper::getConfiguration());
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Judopay\Model\Transaction');
    }

    public function it_should_list_all_transactions()
    {
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

    public function it_should_send_paging_parameters_with_a_request()
    {
        // Setup: we need the mock plugin to examine the request afterwards
        $client = new \Guzzle\Http\Client();
        $plugin = new \Guzzle\Plugin\Mock\MockPlugin();
        $mockResponse = SpecHelper::getMockResponse(200);
        $plugin->addResponse($mockResponse);
        $client->addSubscriber($plugin);
        $this->setClient($client);

        // Get all records and check paging parameters were sent correctly
        $pagingOptions = array(
            'offset' => 100,
            'pageSize' => 99,
            'sort' => 'time-descending'
        );

        $output = $this->all(
            $pagingOptions['offset'],
            $pagingOptions['pageSize'],
            $pagingOptions['sort']
        );

        // Verify that the query string matches the input
        $requests = $plugin->getReceivedRequests();
        expect($requests[0]->getQuery()->urlEncode())->toBeLike($pagingOptions);
    }

    public function it_should_only_allow_valid_api_methods_to_be_called()
    {
        $this->beConstructedWith(SpecHelper::getConfiguration());

        // 'create' is not a valid method on Transaction
        $this->shouldThrow('\RuntimeException')->during('create');

    }
}