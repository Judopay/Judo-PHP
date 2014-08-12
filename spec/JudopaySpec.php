<?php

namespace spec;

require_once __DIR__.'/../src/Judopay.php';

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class JudopaySpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType('Judopay');
    }

    public function it_should_set_config_values_on_initialisation()
    {
        $this->beConstructedWith(
            array(
                'apiToken' => 'token',
                'apiSecret' => 'secret',
                'dodgy_key' => 'dodgy value'
            )
        );

        $this->get('configuration')->getAll()->shouldBeArray();
        $this->get('configuration')->getAll()->shouldNotHaveKey('dodgy_key');
    }

    public function it_should_return_a_model_instance()
    {
        $this->getModel('transaction')->shouldHaveType('\Judopay\Model\Transaction');
    }

    public function getMatchers()
    {
        return [
            'notHaveKey' => function($subject, $key) {
                return !array_key_exists($key, $subject);
            }
        ];
    }
}