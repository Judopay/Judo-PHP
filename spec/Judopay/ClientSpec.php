<?php

namespace spec\Judopay;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ClientSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Judopay\Client');
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

    	$this->getConfig()->shouldReturn(
    		array(
				'api_token' => 'token',
				'api_secret' => 'secret'
    		)
    	);
    }
}
