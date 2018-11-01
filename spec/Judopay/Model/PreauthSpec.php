<?php

namespace spec\Judopay\Model;

use Judopay\Model\Preauth;
use Judopay\Request;

class PreauthSpec extends ModelObjectBehavior
{
    public function it_is_initializable()
    {
        $this->beConstructedWith(new Request($this->configuration));
        $this->shouldHaveType('Judopay\Model\Preauth');
    }

    public function it_should_list_all_transactions()
    {
        $request = $this->concoctRequest('transactions/all.json');
        $this->beConstructedWith($request);

        /** @var Preauth|PreauthSpec $this */
        $output = $this->all();
        $output->shouldBeArray();
        $output['results'][0]['amount']->shouldEqual(1.01);
    }
}
