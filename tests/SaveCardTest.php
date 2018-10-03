<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Tests\Builders\SaveCardBuilder;
use Tests\Helpers\AssertionHelper;
use Tests\Helpers\ConfigHelper;

abstract class SaveCardTests extends TestCase
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
