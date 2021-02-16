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
        // Add any missing key
        if (!array_key_exists('authenticationSource', $threeDSecure)) {
            $threeDSecure += array('authenticationSource' => 'Unknown');
        }

        if (!array_key_exists('methodCompletion', $threeDSecure)) {
            $threeDSecure += array('methodCompletion' => 'Unknown');
        }

        if (!array_key_exists('methodNotificationUrl', $threeDSecure)) {
            $threeDSecure += array('methodNotificationUrl' => null);
        }

        if (!array_key_exists('challengeNotificationUrl', $threeDSecure)) {
            $threeDSecure += array('challengeNotificationUrl' => null);
        }

        $this->setAttribute('threeDSecure', $threeDSecure);
        return $this;
    }
}
