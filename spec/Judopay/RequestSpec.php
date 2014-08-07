<?php

namespace spec\Judopay;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RequestSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
    	$this->beConstructedWith(\Judopay\SpecHelper::getConfiguration());
        $this->shouldHaveType('Judopay\Request');
    }

    public function it_sends_the_right_authorization_header_for_oauth2()
    {
    	// Add access token to configuration
    	$oauthAccessToken = 'xyz';
    	$config = \Judopay\SpecHelper::getConfiguration();
    	$config->add('oauthAccessToken', $oauthAccessToken);

    	// Create a request
    	$this->beConstructedWith($config);
    	$request = new \Guzzle\Http\Message\Request('get', 'http://example.com');

    	// Add the auth information to the request
    	$requestWithAuth = $this->setRequestAuthentication($request);

    	// Make sure the Authorization header is correct
    	$requestWithAuth->getHeader('Authorization')->__toString()->shouldEqual('Bearer '.$oauthAccessToken);
    }

    public function getMatchers()
    {
        return [
            'startWith' => function($subject, $key) {
                return (stripos(trim($subject), $key) === 0);
            }
        ];
    }
}
