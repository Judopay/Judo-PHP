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

    function it_raises_an_exception_when_there_is_a_problematic_response()
    {
    	$exceptions = array(
    		400 => 'BadRequest',
    		401 => 'NotAuthorized',
    		403 => 'NotAuthorized',
    		404 => 'NotFound',
    		409 => 'Conflict',
    		500 => 'InternalServerError',
    		502 => 'BadGateway',
    		503 => 'ServiceUnavailable',
    		504 => 'GatewayTimeout'
    	);

    	foreach ($exceptions as $statusCode => $exceptionClass) {
    		$response = new \Guzzle\Http\Message\Response($statusCode);
    		$this->shouldThrow('\Judopay\Exception\\'.$exceptionClass)->during('__construct', array($response));
    	}
    }
}
