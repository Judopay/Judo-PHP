<?php

namespace Tests\Builders;

class GooglePaymentBuilder extends AbstractModelBuilder
{
    public function __construct()
    {
        $this->attributeValues = array(
            "googlePayWallet" => array(
                "cardNetwork"       => "VISA",
                "cardDetails"       => "5236",
                "token"             => "EncryptedGooglePayload",
            ),
            "currency"              => "GBP",
            "judoId"                => "123456",
            "yourPaymentReference"  => "GooglePayTestPayment",
            "amount"                => "0.10",
            "yourConsumerReference" => "GooglePayTestConsumer",
        );
    }
}
