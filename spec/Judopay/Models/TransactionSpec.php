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

        $configuration = new \Judopay\Configuration(array(
                'api_token' => 'token',
                'api_secret' => 'secret'
            )
        );

        $this->beConstructedWith($configuration);

        $client = new \Guzzle\Http\Client();
        $plugin = \Judopay\SpecHelper::getMockResponsePlugin(
            200,
            null,
            file_get_contents(__DIR__.'/../../fixtures/transactions/all.json')
        );
        $client->addSubscriber($plugin);
		$this->setClient($client);

		$output = $this->all();
        $output->shouldBeArray();
        $output['results'][0]['amount']->shouldEqual(1.01);
    }
}