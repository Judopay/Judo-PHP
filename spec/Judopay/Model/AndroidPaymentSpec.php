<?php

namespace spec\Judopay\Model;

use Judopay\Exception\ValidationError;
use Judopay\Model\AndroidPayment;
use Judopay\Model\Inner\Wallet;
use Tests\Builders\AndroidPaymentBuilder;

class AndroidPaymentSpec extends ModelObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Judopay\Model\AndroidPayment');
    }

    public function it_should_create_a_new_payment()
    {
        $this->beConstructedWith(
            $this->concoctRequest('transactions/android_payment.json')
        );

        $modelBuilder = new AndroidPaymentBuilder();
        /** @var AndroidPayment|AndroidPaymentSpec $this */
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
            $this->concoctRequest('transactions/android_payment.json')
        );
        $this->shouldThrow('\Judopay\Exception\ValidationError')->during(
            'create'
        );
    }

    public function it_should_use_the_configured_judo_id_if_one_is_not_provided()
    {
        $this->beConstructedWith(
            $this->concoctRequest('transactions/android_payment.json')
        );

        $modelBuilder = new AndroidPaymentBuilder();

        // Set an empty Judo ID to make sure the config value is used
        $modelBuilder->unsetAttribute('judoId');
        /** @var AndroidPayment|AndroidPaymentSpec $this */
        $this->setAttributeValues(
            $modelBuilder->compile()->getAttributeValues()
        );
        $this->create();

        $this->getAttributeValue('judoId')->shouldEqual('123-456');
    }

    public function it_properly_coerces_wallet_field_from_json()
    {
        $input = array(
            'wallet' => '{"wallet":{"encryptedMessage":"SomeBase64encodedData","environment":1,'
                .'"ephemeralPublicKey":"SomeBase64encodedData","googleTransactionId":"someId",'
                .'"instrumentDetails":"1234","instrumentType":"VISA","publicKey":"SomeBase64encodedData",'
                .'"tag":"SomeBase64encodedData","version":1}}',
        );

        $walletObj = new Wallet(
            array(
                "encryptedMessage"    => "SomeBase64encodedData",
                "environment"         => 1,
                "ephemeralPublicKey"  => "SomeBase64encodedData",
                "googleTransactionId" => "someId",
                "instrumentDetails"   => "1234",
                "instrumentType"      => "VISA",
                "publicKey"           => "SomeBase64encodedData",
                "tag"                 => "SomeBase64encodedData",
                "version"             => 1,
            )
        );

        $expectedOutput = $walletObj->toObject();

        /** @var AndroidPayment|AndroidPaymentSpec $this */
        $this->setAttributeValues($input);
        $this->getAttributeValue('wallet')->shouldBeLike($expectedOutput);
    }

    public function it_should_raise_an_error_when_bad_wallet_passed()
    {
        /** @var AndroidPayment|AndroidPaymentSpec $this */
        $this->shouldThrow(
            new ValidationError(sprintf(Wallet::ERROR_MESSAGE_INVALID_JSON, 'Judopay\Model\Inner\Wallet'))
        )
            ->during(
                'setAttributeValues',
                array(array('wallet' => '{"someInvalidJson}}'))
            );

        $this->shouldThrow(
            new ValidationError(sprintf(Wallet::ERROR_MESSAGE_CORRUPTED_OBJECT, 'Judopay\Model\Inner\Wallet'))
        )
            ->during(
                'setAttributeValues',
                array(array('wallet' => 1))
            );

        $this->shouldThrow(
            new ValidationError(
                'Judopay\Model\Inner\Wallet object misses required fields',
                array(
                    'encryptedMessage is missing or empty',
                    'environment is missing or empty',
                    'ephemeralPublicKey is missing or empty',
                    'googleTransactionId is missing or empty',
                    'instrumentDetails is missing or empty',
                    'instrumentType is missing or empty',
                    'publicKey is missing or empty',
                    'tag is missing or empty',
                    'version is missing or empty',
                )
            )
        )
            ->during(
                'setAttributeValues',
                array(array('wallet' => '{"wallet":{}}'))
            );
    }
}
