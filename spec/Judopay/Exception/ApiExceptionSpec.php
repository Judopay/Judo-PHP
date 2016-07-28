<?php

namespace spec\Judopay\Exception;

use Judopay\Exception\ApiException;
use spec\SpecHelper;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ApiExceptionSpec extends ObjectBehavior
{
    public function it_is_initializable_with_right_variables()
    {
        // Random 20 char long hexdec string
        $message = bin2hex(openssl_random_pseudo_bytes(10));
        $code = mt_rand(0, 100);
        $statusCode = mt_rand(0, 500);
        $category = mt_rand(0, 5);

        $this->beConstructedWith($message, $code, $statusCode, $category);
        $this->shouldHaveType('Judopay\Exception\ApiException');
        /** @var ApiException|ApiExceptionSpec $this */
        $this->getMessage()->shouldEqual($message);
        $this->getCode()->shouldEqual($code);
        $this->getHttpStatusCode()->shouldEqual($statusCode);
        $this->getCategory()->shouldEqual($category);
    }

    public function factory_should_return_right_variables()
    {
        $response = SpecHelper::getMockResponseFromFixture(400, 'errors/bad_api_version.json');
        $this->beConstructedThrough('factory', array($response));
        /** @var ApiException|ApiExceptionSpec $this */
        $this->getHttpStatusCode()->shouldEqual(400);
        $this->getMessage()->shouldEqual("API-Version not supported");
        $this->getCode()->shouldEqual(39);
        $this->getCategory()->shouldEqual(1);
    }

    public function factory_should_return_the_model_errors_if_applicable()
    {
        $response = SpecHelper::getMockResponseFromFixture(400, 'errors/bad_currency_field.json');
        $this->beConstructedThrough('factory', array($response));
        /** @var ApiException|ApiExceptionSpec $this */
        $this->getFieldErrors()->shouldHaveCount(3);
    }
}
