<?php

namespace spec\Judopay;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class WrapperSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Judopay\Wrapper');
    }

    public function it_should_set_config_values_on_initialisation()
    {
    	$this->beConstructedWith(
			array(
				'api_token' => 'token',
				'api_secret' => 'secret',
				'dodgy_key' => 'dodgy value'
			)
    	);

    	$this->configuration()->getAll()->shouldReturn(
    		array(
				'api_token' => 'token',
				'api_secret' => 'secret'
    		)
    	);
    }

    public function it_should_return_a_transaction_model()
    {
        $this->transaction()->shouldHaveType('Judopay\Models\Transaction');
    }
}
