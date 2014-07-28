<?php

namespace spec\Judopay\Exception;

require_once __DIR__.'/../../SpecHelper.php';

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;


class ApiExceptionSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->beConstructedWith(\Judopay\SpecHelper::getMockResponse(200));
        $this->shouldHaveType('Judopay\Exception\ApiException');
    }

    public function it_should_return_the_http_status_code()
    {
        $statusCode = 400;
        $response = \Judopay\SpecHelper::getMockResponse($statusCode);
        $this->beConstructedWith($response);
        $this->getHttpStatusCode()->shouldEqual($statusCode);
    }

    public function it_should_return_the_http_response_body()
    {
        $responseBody = 'judo judo judo';
        $response = \Judopay\SpecHelper::getMockResponse(200, $responseBody);
        $this->beConstructedWith($response);
        $this->getHttpBody()->shouldEqual($responseBody);
    }

    public function it_should_return_the_model_errors_if_applicable()
    {
        $response = \Judopay\SpecHelper::getMockResponseFromFixture(400, 'card_payments/create_bad_request.json');
        $this->beConstructedWith($response);
        $this->getModelErrors()->shouldEqual(array('Something went pear-shaped'));
    }

    public function it_should_return_a_summary_message()
    {

    }
}
