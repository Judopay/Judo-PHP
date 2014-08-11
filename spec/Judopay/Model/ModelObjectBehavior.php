<?php

namespace spec\Judopay\Model;

require_once __DIR__.'/../../SpecHelper.php';

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

abstract class ModelObjectBehavior extends ObjectBehavior
{
    protected $configuration;

    public function let()
    {
        $this->configuration = \Judopay\SpecHelper::getConfiguration();
        $this->beConstructedWith(
            new \Judopay\Request($this->configuration)
        );
    }

    protected function concoctRequest($fixtureFile)
    {
        $request = new \Judopay\Request($this->configuration);
        $request->setClient(
            \Judopay\SpecHelper::getMockResponseClient(
                200,
                $fixtureFile
            )
        );

        return $request;
    }

    public function getMatchers()
    {
        return [
            'contain' => function($subject, $key) {
                return (strpos($subject, $key) !== false);
            }
        ];
    }
}