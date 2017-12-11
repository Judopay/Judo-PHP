<?php

namespace Tests;

use Tests\Base\PaymentTests;
use Tests\Builders\SaveCardBuilder;

abstract class SaveCardTests extends PHPUnit_Framework_TestCase
{
    public function testValidSaveCard()
    {
        $saveCard = $this->getBuilder()
            ->setAttribute('cv2', '')
            ->build(ConfigHelper::getConfig());

        $result = $saveCard->create();

        AssertionHelper::assertSuccessfulPayment($result);
    }

    public function testValidSaveCardWithNoCv2()
    {
        $saveCard = $this->getBuilder()
            ->build(ConfigHelper::getConfig());

        $result = $saveCard->create();

        AssertionHelper::assertSuccessfulPayment($result);
    }

    protected function getBuilder()
    {
        return new SaveCardBuilder();
    }
}
