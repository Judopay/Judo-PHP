<?php

namespace spec\Judopay\Model;

use Judopay\Exception\ValidationError;
use Judopay\Model\GooglePayment;
use Judopay\Model\Inner\GooglePayWallet;
use Tests\Builders\GooglePaymentBuilder;

class GooglePaymentSpec extends ModelObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Judopay\Model\GooglePayment');
    }

    public function it_should_create_a_new_payment()
    {
        $this->beConstructedWith(
            $this->concoctRequest('transactions/google_payment.json')
        );

        $modelBuilder = new GooglePaymentBuilder();
        /** @var GooglePayment|GooglePaymentSpec $this */
        $this->setAttributeValues(
            $modelBuilder->compile()->getAttributeValues()
        );
        $output = $this->create();

        $output->shouldBeArray();
        $output['result']->shouldEqual('Success');
    }

    public function it_should_raise_an_error_when_required_fields_are_missing()
    {
        $this->beConstructedWith(
            $this->concoctRequest('transactions/google_payment.json')
        );
        $this->shouldThrow('\Judopay\Exception\ValidationError')->during(
            'create'
        );
    }

    public function it_should_use_the_configured_judo_id_if_one_is_not_provided()
    {
        $this->beConstructedWith(
            $this->concoctRequest('transactions/google_payment.json')
        );

        $modelBuilder = new GooglePaymentBuilder();

        // Set an empty Judo ID to make sure the config value is used
        $modelBuilder->unsetAttribute('judoId');
        /** @var GooglePayment|GooglePaymentSpec $this */
        $this->setAttributeValues(
            $modelBuilder->compile()->getAttributeValues()
        );
        $this->create();

        $this->getAttributeValue('judoId')->shouldEqual('123-456');
    }

    public function it_properly_coerces_wallet_field_from_json()
    {
        $input = array(
            'googlePayWallet' => '{"googlePayWallet":{'
                .'"cardNetwork":"VISA",'
                .'"cardDetails":"5326",'
                .'"token":"EncryptedGooglePayload"'
                .'}}',
        );

        $googlePayWalletObj = new GooglePayWallet(
            array(
                "cardNetwork"       => "VISA",
                "cardDetails"       => "5326",
                "token"             => "EncryptedGooglePayload",
            )
        );

        $expectedOutput = $googlePayWalletObj->toObject();

        /** @var GooglePayment|GooglePaymentSpec $this */
        $this->setAttributeValues($input);
        $this->getAttributeValue('googlePayWallet')->shouldBeLike($expectedOutput);
    }

    public function it_should_raise_an_error_when_bad_wallet_passed()
    {
        /** @var GooglePayment|GooglePaymentSpec $this */
        $this->shouldThrow(
            new ValidationError(sprintf(
                GooglePayWallet::ERROR_MESSAGE_INVALID_JSON,
                'Judopay\Model\Inner\GooglePayWallet'
            ))
        )
            ->during(
                'setAttributeValues',
                array(array('googlePayWallet' => '{"someInvalidJson}}'))
            );

        $this->shouldThrow(
            new ValidationError(sprintf(
                GooglePayWallet::ERROR_MESSAGE_CORRUPTED_OBJECT,
                'Judopay\Model\Inner\GooglePayWallet'
            ))
        )
            ->during(
                'setAttributeValues',
                array(array('googlePayWallet' => 1))
            );

        $this->shouldThrow(
            new ValidationError(
                'Judopay\Model\Inner\GooglePayWallet object misses required fields',
                array(
                    'cardNetwork is missing or empty',
                    'cardDetails is missing or empty',
                    'token is missing or empty',
                )
            )
        )
            ->during(
                'setAttributeValues',
                array(array('googlePayWallet' => '{"googlePayWallet":{}}'))
            );
    }
}
