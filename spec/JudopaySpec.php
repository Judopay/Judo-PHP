<?php

namespace spec;

require_once __DIR__.'/../src/Judopay.php';

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class JudopaySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Judopay');
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

    	$this->get('configuration')->getAll()->shouldReturn(
    		array(
				'api_token' => 'token',
				'api_secret' => 'secret'
    		)
    	);
    }

    public function it_should_return_a_model_instance()
    {
        $this->get_model('transaction')->shouldHaveType('\Judopay\Models\Transaction');
    }
}
