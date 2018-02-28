<?php

namespace Tests;

use PHPUnit_Framework_TestCase;
use Tests\Builders\EncryptDetailsBuilder;
use Tests\Helpers\AssertionHelper;
use Tests\Helpers\ConfigHelper;

class AdditionsPaymentTest extends \PHPUnit_Framework_TestCase
{

    public function testOneUseTokenPayment() {
        $encryptDetails = $this->getBuilder()
            ->build(ConfigHelper::getConfig());

        $encryptionResult = $encryptDetails->create();

        $this->assertNotEmpty($encryptionResult['oneUseToken']);
    }

    protected function getBuilder()
    {
        return new EncryptDetailsBuilder();
    }

}