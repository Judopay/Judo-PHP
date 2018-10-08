<?php

namespace Tests\Builders;

class RegisterEncryptedCardBuilder extends AbstractModelBuilder
{
    public function __construct()
    {
        $this->attributeValues = array(
            'yourConsumerReference' => 'oneUseTokenRegisterCardPhpTestConsumer',
            'yourPaymentReference'  => substr(md5(rand()), 0, 7),
            'amount'                => 1.01,
            'currency'              => 'GBP'
        );
    }
}
