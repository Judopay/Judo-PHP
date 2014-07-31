<?php

namespace spec\Judopay\Models;

require_once __DIR__.'/../../SpecHelper.php';

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Guzzle\Http\Client;

class CardPaymentSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->beConstructedWith(\Judopay\SpecHelper::getConfiguration());
        $this->shouldHaveType('Judopay\Models\CardPayment');
    }

    // Generic model methods
    public function it_coerces_attributes_into_the_correct_data_type()
    {
        $this->beConstructedWith(\Judopay\SpecHelper::getConfiguration());
        $input = array(
            'yourPaymentMetaData' => 'an unexpected string',
            'judoId' => 'judo123',
            'amount' => '123.23'
        );

        $expectedOutput = array(
            'yourPaymentMetaData' => array('an unexpected string'),
            'judoId' => 'judo123',
            'amount' => 123.23
        );

        $this->setAttributeValues($input);
        $this->getAttributeValues()->shouldEqual($expectedOutput);
    }

    public function it_should_baulk_at_very_unusual_float_values()
    {
        $this->beConstructedWith(\Judopay\SpecHelper::getConfiguration());
        $input = array(
            'amount' => '123.23GBP'
        );

        $this->shouldThrow('\OutOfBoundsException')->during('setAttributeValues', array($input));
    }
}
