<?php

namespace Tests\Builders;

class CardPaymentBuilder extends AbstractModelBuilder
{
    const VALID_VISA_CARD = 0;
    const INVALID_VISA_CARD = 1;
    const THREEDS_VISA_CARD = 2;
    const THREEDSTWO_VISA_CARD = 3;

    protected $type = self::VALID_VISA_CARD;

    public function __construct($amount = 1.02)
    {
        $this->attributeValues = array(
            'yourConsumerReference' => '12345',
            'amount'                => $amount,
            'currency'              => 'GBP',
        );
    }

    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function setThreeDSecureTwoFields($threeDSecure)
    {
        $this->setAttribute('threeDSecure', $threeDSecure);
        $this->setAttribute('cardHolderName', 'CHALLENGE');
        $this->setAttribute('phoneCountryCode', '44');
        $this->setAttribute('mobileNumber', '07999999999');
        $this->setAttribute('emailAddress', 'contact@judopay.com');

        return $this;
    }

    public function compile()
    {
        parent::compile();

        switch ($this->type) {
            case self::VALID_VISA_CARD:
                $this->attributeValues += array(
                    'cardNumber' => '4976000000003436',
                    'expiryDate' => '12/25',
                    'cv2'        => 452,
                );
                break;

            case self::INVALID_VISA_CARD:
                $this->attributeValues += array(
                    'cardNumber' => '4221690000004963',
                    'expiryDate' => '12/25',
                    'cv2'        => 125,
                );
                break;

            case self::THREEDS_VISA_CARD:
                $this->attributeValues += array(
                    'cardNumber' => '4976350000006891',
                    'expiryDate' => '12/25',
                    'cv2'        => 341,
                );
                break;

            case self::THREEDSTWO_VISA_CARD:
                $this->attributeValues += array(
                    'cardNumber' => '4000023104662535',
                    'expiryDate' => '12/25',
                    'cv2'        => 452,
                );
                break;
        }

        return $this;
    }
}
