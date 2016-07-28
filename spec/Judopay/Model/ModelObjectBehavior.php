<?php

namespace spec\Judopay\Model;

use Judopay\Request;
use spec\SpecHelper;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

abstract class ModelObjectBehavior extends ObjectBehavior
{
    protected $configuration;

    public function let()
    {
        $this->configuration = SpecHelper::getConfiguration();
        $this->beConstructedWith(new Request($this->configuration));
    }

    protected function concoctRequest($fixtureFile)
    {
        $request = new Request($this->configuration);
        $request->setClient(
            SpecHelper::getMockResponseClient(
                200,
                $fixtureFile
            )
        );

        return $request;
    }

    public function getMatchers()
    {
        return array(
            'contain' => function ($subject, $key) {
                return (strpos($subject, $key) !== false);
            },
        );
    }
}
