<?php

namespace Tests\Builders;

use Judopay\Client;
use Judopay\Configuration;
use Judopay\Model;
use Judopay\Request;

/**
 * Build model objects with standard test data
 * to reduce duplication in tests
 **/
abstract class AbstractModelBuilder
{
    /**
     * Array of attributes (key => value)
     * @var array
     **/
    protected $attributeValues;

    /**
     * Create a new model object with attributes set
     * @param Configuration $configuration
     * @return Model Model object
     */
    public function build(Configuration $configuration = null)
    {
        $this->compile();
        $request = new Request($configuration ?: new Configuration());
        $request->setClient(new Client());

        $modelName = '\Judopay\Model\\'.substr(get_class($this), 15, -7);

        /** @var Model $model */
        $model = new $modelName($request);
        $model->setAttributeValues($this->attributeValues);

        return $model;
    }

    /**
     * Retrieve an array of test data attributes
     * Can be used directly in a setAttributeValues() method call
     * @return array Array of attribute values (key => value)
     **/
    public function getAttributeValues()
    {
        return $this->attributeValues;
    }

    public function setAttribute($attribute, $value)
    {
        $this->attributeValues[$attribute] = $value;

        return $this;
    }

    public function unsetAttribute($attribute)
    {
        unset($this->attributeValues[$attribute]);

        return $this;
    }

    public function compile()
    {
        $this->attributeValues['yourPaymentReference'] = sha1(time().mt_rand(0, 10000));

        return $this;
    }
}
