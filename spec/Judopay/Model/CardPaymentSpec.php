<?php

namespace spec\Judopay\Model;

use Judopay\Model\CardPayment;
use Tests\Builders\CardPaymentBuilder;

class CardPaymentSpec extends ModelObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('Judopay\Model\CardPayment');
    }

    public function it_should_create_a_new_payment()
    {
        $this->beConstructedWith(
            $this->concoctRequest('card_payments/create.json')
        );

        $modelBuilder = new CardPaymentBuilder();
        /** @var CardPayment|CardPaymentSpec $this */
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
            $this->concoctRequest('card_payments/create.json')
        );
        $this->shouldThrow('\Judopay\Exception\ValidationError')->during(
            'create'
        );
    }

    public function it_should_validate_a_new_payment_given_valid_card_details()
    {
        $this->beConstructedWith(
            $this->concoctRequest('card_payments/validate.json')
        );

        $modelBuilder = new CardPaymentBuilder();
        /** @var CardPayment|CardPaymentSpec $this */
        $this->setAttributeValues(
            $modelBuilder->compile()->setAttribute('judoId', '12345')->getAttributeValues()
        );
        $output = $this->validate();

        $output->shouldBeArray();
        $output['errorMessage']->shouldContain('good to go');
    }

    public function it_should_use_the_configured_judo_id_if_one_is_not_provided()
    {
        $this->beConstructedWith(
            $this->concoctRequest('card_payments/create.json')
        );

        $modelBuilder = new CardPaymentBuilder();

        // Set an empty Judo ID to make sure the config value is used
        $modelBuilder->unsetAttribute('judoId');
        /** @var CardPayment|CardPaymentSpec $this */
        $this->setAttributeValues(
            $modelBuilder->compile()->getAttributeValues()
        );
        $this->create();

        $this->getAttributeValue('judoId')->shouldEqual('123-456');
    }

    // Generic model methods
    public function it_coerces_attributes_into_the_correct_data_type()
    {
        $input = array(
            'yourPaymentMetaData' => (object)array('val' => 'an unexpected string'),
            'judoId'              => 'judo123',
            'amount'              => '123.23',
        );

        $expectedOutput = array(
            'yourPaymentMetaData' => (object)array('val' => 'an unexpected string'),
            'judoId'              => 'judo123',
            'amount'              => 123.23,
        );

        /** @var CardPayment|CardPaymentSpec $this */
        $this->setAttributeValues($input);
        $this->getAttributeValues()->shouldBeLike($expectedOutput);
    }

    public function it_should_baulk_at_very_unusual_float_values()
    {
        $input = array(
            'amount' => '123.23GBP',
        );

        $this->shouldThrow('Judopay\Exception\ValidationError')
            ->during('setAttributeValues', array($input));
    }
}
