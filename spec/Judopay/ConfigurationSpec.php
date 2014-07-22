<?php

namespace spec\Judopay;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConfigurationSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Judopay\Configuration');
    }

    public function it_sets_the_correct_endpoint_url()
    {
    	$this->beConstructedWith(
			array(
				'use_production' => true
			)
    	);

    	$this->get('endpoint_url')->shouldBe('http://production.local');
    }
}
