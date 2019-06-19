<?php

namespace spec\Judopay;

use Judopay\Request;
use spec\SpecHelper;
use PhpSpec\ObjectBehavior;

class ModelSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->beConstructedWith(
            new Request(SpecHelper::getConfiguration())
        );
        $this->shouldHaveType('Judopay\Model');
    }
}
