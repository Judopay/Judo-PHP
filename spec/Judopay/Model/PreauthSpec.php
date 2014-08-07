<?php

namespace spec\Judopay\Model;

require_once 'ModelObjectBehavior.php';

class PreauthSpec extends ModelObjectBehavior
{
    public function it_is_initializable()
    {
        $this->beConstructedWith(new \Judopay\Request($this->configuration));
        $this->shouldHaveType('Judopay\Model\Preauth');
    }

    public function it_should_list_all_transactions()
    {
        $request = new \Judopay\Request($this->configuration);
        $request->setClient(
            \Judopay\SpecHelper::getMockResponseClient(
                200,
                'transactions/all.json'
            )
        );

        $this->beConstructedWith($request);

		$output = $this->all();
        $output->shouldBeArray();
        $output['results'][0]['amount']->shouldEqual(1.01);
    }
}