<?php

namespace spec\Judopay;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ResponseValidatorSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
    	$this->beConstructedWith(new \Guzzle\Http\Message\Response(200));
        $this->shouldHaveType('Judopay\ResponseValidator');
    }
}
