<?php

namespace spec\Judopay;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ModelSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Judopay\Model');
    }
}
