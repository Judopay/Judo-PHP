<?php

namespace spec\Judopay;

use Guzzle\Http\Message\Request;
use spec\SpecHelper;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RequestSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->beConstructedWith(SpecHelper::getConfiguration());
        $this->shouldHaveType('Judopay\Request');
    }

    public function it_sends_the_right_authorization_header_for_oauth2()
    {
        // Add access token to configuration
        $oauthAccessToken = 'xyz';
        $config = SpecHelper::getConfiguration();
        $config->add('oauthAccessToken', $oauthAccessToken);

        // Create a request
        $this->beConstructedWith($config);
        $request = new Request('get', 'http://example.com');

        /** @var \Judopay\Request $this */
        // Add the auth information to the request
        $requestWithAuth = $this->setRequestAuthentication($request);

        // Make sure the Authorization header is correct
        $requestWithAuth->getHeader('Authorization')
            ->__toString()
            ->shouldEqual('Bearer '.$oauthAccessToken);
    }

    public function getMatchers()
    {
        return array(
            'startWith' => function ($subject, $key) {
                return (stripos(trim($subject), $key) === 0);
            },
        );
    }
}
