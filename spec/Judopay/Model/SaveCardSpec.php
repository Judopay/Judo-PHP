<?php

namespace spec\Judopay\Model;

use Judopay\Request;

require_once 'ModelObjectBehavior.php';

class SaveCardSpec extends ModelObjectBehavior
{
    public function it_is_initializable()
    {
        $this->beConstructedWith(new Request($this->configuration));
        $this->shouldHaveType('Judopay\Model\SaveCard');
    }

    public function it_should_save_new_card()
    {
        $this->beConstructedWith($this->concoctRequest('transactions/save_card.json'));

        $this->setAttributeValues(
            [
                'yourConsumerReference' => '12345',
                'cardNumber'            => '4976000000003436',
                'expiryDate'            => '12/20',
                'cv2'                   => 452,
            ]
        );

        $output = $this->create();

        $output->shouldBeArray();
        $output['result']->shouldEqual('Success');
        $output['type']->shouldEqual('Register');
    }
}