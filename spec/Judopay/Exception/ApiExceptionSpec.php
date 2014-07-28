<?php

namespace spec\Judopay\Exception;

require_once __DIR__.'/../../SpecHelper.php';

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;


class ApiExceptionSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->beConstructedWith('OK', \Judopay\SpecHelper::getMockResponse(200));
        $this->shouldHaveType('Judopay\Exception\ApiException');
    }

    public function it_should_return_the_http_status_code()
    {
        $statusCode = 400;
        $response = \Judopay\SpecHelper::getMockResponse($statusCode);
        $this->beConstructedWith('Bad Request', $response);
        $this->getHttpStatusCode()->shouldEqual($statusCode);
    }

    public function it_should_return_the_http_response_body()
    {
        $responseBody = 'judo judo judo';
        $response = \Judopay\SpecHelper::getMockResponse(200, $responseBody);
        $this->beConstructedWith('OK', $response);
        $this->getHttpBody()->shouldEqual($responseBody);
    }

    public function it_should_return_the_model_errors_if_applicable()
    {
        $response = \Judopay\SpecHelper::getMockResponseFromFixture(400, 'card_payments/create_bad_request.json');
        $this->beConstructedWith('Bad Request', $response);
        $this->getModelErrors()->shouldEqual(array('Something went pear-shaped'));
    }

    public function it_should_return_a_summary_message()
    {
        $expectedReturn = 'Please check the card token. (Something went pear-shaped)';
        $response = \Judopay\SpecHelper::getMockResponseFromFixture(400, 'card_payments/create_bad_request.json');
        $this->beConstructedWith('Bad Request', $response);
        $this->__toString()->shouldEqual($expectedReturn);
        $this->getSummary()->shouldEqual($expectedReturn);
    }

    public function it_should_return_the_error_type_in_get_message()
    {
        $response = \Judopay\SpecHelper::getMockResponseFromFixture(400, 'card_payments/create_bad_request.json');
        $this->beConstructedWith('Bad Request', $response);
        $this->getMessage()->shouldEqual('Bad Request');
    }
}