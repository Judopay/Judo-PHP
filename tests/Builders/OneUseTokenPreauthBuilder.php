<?php

namespace Tests\Builders;

class OneUseTokenPreauthBuilder extends AbstractModelBuilder
{
    public function __construct()
    {
        $this->attributeValues = array(
            'yourConsumerReference' => 'oneUseTokenPhpTestConsumer',
            'yourPaymentReference'  => substr(md5(rand()), 0, 7),
            'amount'                => 1.01,
            'currency'              => 'GBP'
        );
    }
}
