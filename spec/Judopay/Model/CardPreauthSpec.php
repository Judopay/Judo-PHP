<?php

namespace spec\Judopay\Model;

require_once __DIR__.'/../../SpecHelper.php';

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Guzzle\Http\Client;

class CardPreauthSpec extends ObjectBehavior
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
        $this->shouldHaveType('Judopay\Model\CardPreauth');
    }

    public function it_should_create_a_new_preauth()
    {
        $this->beConstructedWith($this->concoctRequest());

        $this->setAttributeValues(
            array(
                'judoId' => 12345,
                'yourConsumerReference' => '12345',
                'yourPaymentReference' => '12345',
                'judoId' => '123-456-789',
                'amount' => 1.01,
                'cardNumber' => '4976000000003436',
                'expiryDate' => '12/15',
                'cv2' => 452
            )
        );
        $output = $this->create();

        $output->shouldBeArray();
        $output['result']->shouldEqual('Success');
    }

    protected function concoctRequest()
    {
        $request = new \Judopay\Request($this->configuration);
        $request->setClient(
            \Judopay\SpecHelper::getMockResponseClient(
                200,
                'card_payments/create.json'
            )
        );

        return $request;
    }
}