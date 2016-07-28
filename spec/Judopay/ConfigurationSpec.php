<?php

namespace spec\Judopay;

use Judopay\Configuration;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ConfigurationSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Judopay\Configuration');
    }

    public function it_sets_the_correct_endpoint_url()
    {
        $this->beConstructedWith(array('useProduction' => true));

        /** @var Configuration|ConfigurationSpec $this */
        $this->get('endpointUrl')->shouldBe('https://gw1.judopay.com');
    }

    public function it_should_allow_a_custom_api_version_to_be_set()
    {
        $this->beConstructedWith(array('apiVersion' => '4.0.1'));

        /** @var Configuration|ConfigurationSpec $this */
        $this->get('apiVersion')->shouldBe('4.0.1');
    }
}
