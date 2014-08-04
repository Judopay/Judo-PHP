<?php

namespace spec\Judopay\Model;

require_once __DIR__.'/../../SpecHelper.php';

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Guzzle\Http\Client;

class CardPaymentSpec extends ObjectBehavior
{
    protected $configuration;

    public function let()
    {
        $this->configuration = \Judopay\SpecHelper::getConfiguration();
        $this->beConstructedWith(
            new \Judopay\Request($this->configuration)
        );
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Judopay\Model\CardPayment');
    }

    public function it_should_create_a_new_payment()
    {
        $request = new \Judopay\Request($this->configuration);
        $request->setClient(
            \Judopay\SpecHelper::getMockResponseClient(
                200,
                'card_payments/create.json'
            )
        );

        $this->beConstructedWith($request);

        $output = $this->create(
            array(
                'judoId' => 12345
            )
        );

        $output->shouldBeArray();
        $output['result']->shouldEqual('Success');

    }

    // Generic model methods
    public function it_coerces_attributes_into_the_correct_data_type()
    {
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
        $input = array(
            'amount' => '123.23GBP'
        );

        $this->shouldThrow('\OutOfBoundsException')->during('setAttributeValues', array($input));
    }
}