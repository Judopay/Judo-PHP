<?php

namespace spec\Judopay\Exception;

use Judopay\Exception\FieldError;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class FieldErrorSpec extends ObjectBehavior
{
    public function it_is_initializable_with_right_variables()
    {
        // Random 20 char long hexdec string
        $message = bin2hex(openssl_random_pseudo_bytes(10));
        $fieldName = bin2hex(openssl_random_pseudo_bytes(10));
        $details = bin2hex(openssl_random_pseudo_bytes(10));
        $code = mt_rand(0, 100);

        $this->beConstructedWith($message, $code, $fieldName, $details);
        $this->shouldHaveType('Judopay\Exception\FieldError');
        /** @var FieldError|FieldErrorSpec $this */
        $this->getMessage()->shouldEqual($message);
        $this->getCode()->shouldEqual($code);
        $this->getFieldName()->shouldEqual($fieldName);
        $this->getDetails()->shouldEqual($details);
    }
}
