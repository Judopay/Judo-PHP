<?php

namespace spec\Judopay\Model;

use Judopay\Exception\ValidationError;
use Judopay\Model\ApplePayment;
use Judopay\Model\Inner\PkPayment;
use Tests\Builders\ApplePaymentBuilder;

class ApplePaymentSpec extends ModelObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Judopay\Model\ApplePayment');
    }

    public function it_should_create_a_new_payment()
    {
        $this->beConstructedWith(
            $this->concoctRequest('transactions/apple_payment.json')
        );

        $modelBuilder = new ApplePaymentBuilder();
        /** @var ApplePayment|ApplePaymentSpec $this */
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
            $this->concoctRequest('transactions/apple_payment.json')
        );
        $this->shouldThrow('\Judopay\Exception\ValidationError')->during(
            'create'
        );
    }

    public function it_should_use_the_configured_judo_id_if_one_is_not_provided()
    {
        $this->beConstructedWith(
            $this->concoctRequest('transactions/apple_payment.json')
        );

        $modelBuilder = new ApplePaymentBuilder();

        // Set an empty Judo ID to make sure the config value is used
        $modelBuilder->unsetAttribute('judoId');
        /** @var ApplePayment|ApplePaymentSpec $this */
        $this->setAttributeValues(
            $modelBuilder->compile()->getAttributeValues()
        );
        $this->create();

        $this->getAttributeValue('judoId')->shouldEqual('123-456');
    }

    public function it_properly_coerces_pk_payment_field_from_json()
    {
        $input = array(
            'pkPayment' => '{"pkPayment":{"token":{"paymentInstrumentName":"Visa XXXX","paymentNetwork":"Visa",'
                .'"paymentData":{"version":"EC_v1","data":"SomeBase64encodedData","signature":"SomeBase64encodedData",'
                .'"header":{"ephemeralPublicKey":"someKey","publicKeyHash":"someKey","transactionId":"someId"}}},'
                .'"billingAddress":null,"shippingAddress":null}}',
        );

        $pkObj = new PkPayment(
            array(
                "token"           => array(
                    "paymentInstrumentName" => "Visa XXXX",
                    "paymentNetwork"        => "Visa",
                    "paymentData"           => array(
                        "version"   => "EC_v1",
                        "data"      => "SomeBase64encodedData",
                        "signature" => "SomeBase64encodedData",
                        "header"    => array(
                            "ephemeralPublicKey" => "someKey",
                            "publicKeyHash"      => "someKey",
                            "transactionId"      => "someId",
                        ),
                    ),
                ),
                "billingAddress"  => null,
                "shippingAddress" => null,
            )
        );

        $expectedOutput = $pkObj->toObject();

        /** @var ApplePayment|ApplePaymentSpec $this */
        $this->setAttributeValues($input);
        $this->getAttributeValue('pkPayment')->shouldBeLike($expectedOutput);
    }

    public function it_should_raise_an_error_when_bad_pk_payment_passed()
    {
        /** @var ApplePayment|ApplePaymentSpec $this */
        $this->shouldThrow(
            new ValidationError(sprintf(PkPayment::ERROR_MESSAGE_INVALID_JSON, 'Judopay\Model\Inner\PkPayment'))
        )
            ->during(
                'setAttributeValues',
                array(array('pkPayment' => '{"someInvalidJson}}'))
            );

        $this->shouldThrow(
            new ValidationError(sprintf(PkPayment::ERROR_MESSAGE_CORRUPTED_OBJECT, 'Judopay\Model\Inner\PkPayment'))
        )
            ->during(
                'setAttributeValues',
                array(array('pkPayment' => 1))
            );

        $this->shouldThrow(
            new ValidationError(
                'Judopay\Model\Inner\PkPayment object misses required fields',
                array(
                    'token.paymentInstrumentName is missing or empty',
                    'token.paymentNetwork is missing or empty',
                    'token.paymentData is missing or empty',
                )
            )
        )
            ->during(
                'setAttributeValues',
                array(array('pkPayment' => '{"pkPayment":{"token":{}}}'))
            );
    }
}
