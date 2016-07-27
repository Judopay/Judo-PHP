<?php

namespace spec\Judopay\Model\Market;

use Judopay\Model\Market\Preauth;
use Judopay\Request;
use spec\Judopay\Model\ModelObjectBehavior;

class PreauthSpec extends ModelObjectBehavior
{
    public function it_is_initializable()
    {
        $this->beConstructedWith(new Request($this->configuration));
        $this->shouldHaveType('Judopay\Model\Market\Preauth');
    }

    public function it_should_list_all_preauths()
    {
        $request = $this->concoctRequest('transactions/all.json');
        $this->beConstructedWith($request);

        /** @var Preauth|PreauthSpec $this */
        $output = $this->all();
        $output->shouldBeArray();
        $output['results'][0]['amount']->shouldEqual(1.01);
    }
}
