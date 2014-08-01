<?php

namespace spec\Judopay\Model;

require_once __DIR__.'/../../SpecHelper.php';

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use \Judopay\SpecHelper;

class PreauthSpec extends ObjectBehavior
{
    public function let()
    {
        $this->beConstructedWith(\Judopay\SpecHelper::getConfiguration());
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType('Judopay\Model\Preauth');
    }

    public function it_should_list_all_transactions()
    {
		$this->setClient(
            \Judopay\SpecHelper::getMockResponseClient(
                200,
                'transactions/all.json'
            )
        );

		$output = $this->all();
        $output->shouldBeArray();
        $output['results'][0]['amount']->shouldEqual(1.01);
    }
}