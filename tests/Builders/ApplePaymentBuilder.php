<?php

namespace Tests\Builders;

class ApplePaymentBuilder extends AbstractModelBuilder
{
    public function __construct()
    {
        $this->attributeValues = array(
            "pkPayment"             => array(
                "token"           => array(
                    "paymentInstrumentName" => "Visa XXXX",
                    "paymentNetwork"        => "Visa",
                    "paymentData"           => array(
                        "version"   => "EC_v1",
                        "data"      => "SomeBase64encodedData",
                        "signature" => "SomeBase64encodedData",
                        "header"    => array(
                            "ephemeralPublicKey" => "someKey",
                            "publicKeyHash"      => "someKey",
                            "transactionId"      => "someId",
                        ),
                    ),
                ),
                "billingAddress"  => null,
                "shippingAddress" => null,
            ),
            "yourConsumerReference" => "Some_Consumer_reference",
            "amount"                => 0.02,
            "currency"              => "GBP",
            "clientDetails"         => array(
                "key"   => "someKey",
                "value" => "somevalue",
            ),
        );
    }
}
