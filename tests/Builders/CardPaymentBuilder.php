<?php

namespace Tests\Builders;

class CardPaymentBuilder extends AbstractModelBuilder
{
    const VALID_VISA_CARD = 0;
    const INVALID_VISA_CARD = 1;
    protected $type = self::VALID_VISA_CARD;

    public function __construct()
    {
        $this->attributeValues = array(
            'yourConsumerReference' => '12345',
            'amount'                => 1.02,
            'currency'              => 'GBP',
        );
    }

    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function compile()
    {
        parent::compile();

        switch ($this->type) {
            case self::VALID_VISA_CARD:
                $this->attributeValues += array(
                    'cardNumber' => '4976000000003436',
                    'expiryDate' => '12/20',
                    'cv2'        => 452,
                );
                break;

            case self::INVALID_VISA_CARD:
                $this->attributeValues += array(
                    'cardNumber' => '4221690000004963',
                    'expiryDate' => '12/20',
                    'cv2'        => 125,
                );
                break;
        }

        return $this;
    }
}
