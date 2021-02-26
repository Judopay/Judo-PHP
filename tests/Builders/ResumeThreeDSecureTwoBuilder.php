<?php

namespace Tests\Builders;

class ResumeThreeDSecureTwoBuilder extends AbstractModelBuilder
{
    public function __construct($receiptId = '12345')
    {
        $this->attributeValues = array(
            'receiptId'            => $receiptId
        );
    }

    public function setCv2($cv2)
    {
        $this->setAttribute('cv2', $cv2);
        return $this;
    }

    public function setThreeDSecureTwoFields($threeDSecure)
    {
        $this->setAttribute('threeDSecure', $threeDSecure);
        return $this;
    }
}
