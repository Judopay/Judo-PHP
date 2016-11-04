<?php

namespace Tests\Builders;

class AndroidPaymentBuilder extends AbstractModelBuilder
{
    public function __construct()
    {
        $this->attributeValues = array(
            "wallet"                => array(
                "encryptedMessage"    => "ZW5jcnlwdGVkTWVzc2FnZQ==",
                "environment"         => 3,
                "ephemeralPublicKey"  => "ZXBoZW1lcmFsUHVibGljS2V5",
                "googleTransactionId" => "123456789",
                "instrumentDetails"   => "1234",
                "instrumentType"      => "VISA",
                "publicKey"           => "someKey",
                "tag"                 => "c2lnbmF0dXJl",
                "version"             => 1,
            ),
            "yourConsumerReference" => "AndroidPayTest",
            "amount"                => 0.10,
            "currency"              => "GBP",
            "clientDetails"         => array(
                "key"   => "someKey",
                "value" => "somevalue",
            ),
        );
    }
}
