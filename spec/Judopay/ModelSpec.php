<?php

namespace spec\Judopay;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ModelSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
    	$this->beConstructedWith(new \Judopay\Request(\Judopay\SpecHelper::getConfiguration()));
        $this->shouldHaveType('Judopay\Model');
    }
}
