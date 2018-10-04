<?php

namespace Tests\Builders;

class CheckEncryptedCardBuilder extends AbstractModelBuilder
{
    public function __construct()
    {
        $this->attributeValues = array(
            'yourConsumerReference' => 'oneUseTokenCheckCardPhpTestConsumer',
            'yourPaymentReference'  => substr(md5(rand()), 0, 7),
            'amount'                => 0.00,
            'currency'              => 'GBP'
        );
    }
}
