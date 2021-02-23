<?php

namespace Judopay;

use Judopay\Exception\ValidationError;
use GuzzleHttp\Psr7\Response;

/**
 * Base model class
 * @package Judopay
 **/
class Model
{
    const JUDO_ID = 'judoId';
    /**
     * Request object
     * @var Request
     **/
    protected $request;
    /**
     * Resource path (e.g. /transactions/payments)
     * @var string
     **/
    protected $resourcePath;
    /**
     * Valid API methods for this model
     * e.g. array('all', 'create')
     * @var array
     **/
    protected $validApiMethods;
    /**
     * Attributes with expected data types
     * e.g. array('yourConsumerReference' => DataType::TYPE_STRING)
     * @var array
     **/
    protected $attributes = array();
    /**
     * Attributes with values
     * e.g. array('yourConsumerReference' => '123456')
     * @var array
     **/
    protected $attributeValues = array();
    /**
     * Attributes that must be present before submission to the API
     * e.g. array('yourConsumerReference', 'judoId')
     * @var array
     **/
    protected $requiredAttributes = array();

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Transforms the Guzzle Response to an Array
     * @param Response $guzzleResponse
     * @return array
     **/
    public function getResponseArray($guzzleResponse)
    {
        // Read the Psr7\Stream
        $responseBody = $guzzleResponse->getBody();
        $responseBodyAsString = $responseBody->getContents();

        // Parse the response to Json
        return json_decode($responseBodyAsString, true);
    }

    /**
     * Retrieve a list of records
     * @param  int    $offset   The start point in the sorted list of records from which the results set will start
     * @param  int    $pageSize The number of records to display per page
     * @param  string $sort     Determines how the list is sorted (time-descending or time-ascending)
     * @return array API response
     **/
    public function all($offset = 0, $pageSize = 10, $sort = 'time-descending')
    {
        $this->checkApiMethodIsSupported(__FUNCTION__);
        $pagingOptions = array(
            'offset'   => $offset,
            'pageSize' => $pageSize,
            'sort'     => $sort,
        );

        // Ressource Path with options
        $uri = $this->resourcePath.'?'.http_build_query($pagingOptions);

        $response = $this->request->get(
            $uri
        );

        return $this->getResponseArray($response);
    }

    /**
     * Retrieve a specific record
     * @param  int $resourceId
     * @return array API response
     * @author
     **/
    public function find($resourceId)
    {
        $this->checkApiMethodIsSupported(__FUNCTION__);

        $response = $this->request->get(
            $this->resourcePath.'/'.(int)$resourceId
        );

        return $this->getResponseArray($response);
    }

    /**
     * Create a new record
     * @return array API response
     **/
    public function create()
    {
        $this->checkApiMethodIsSupported(__FUNCTION__);
        $this->checkJudoId();
        $this->checkRequiredAttributes($this->attributeValues);

        $response = $this->request->post(
            $this->resourcePath,
            $this->attributeValues
        );

        return $this->getResponseArray($response);
    }

    /**
     * Update an existing record
     * @return array API response
     **/
    public function update()
    {
        $this->checkApiMethodIsSupported(__FUNCTION__);
        $this->checkJudoId();
        $this->checkRequiredAttributes($this->attributeValues);

        // Replace any placeholder receiptId in a path
        if (strpos($this->resourcePath, 'receiptId') !== false) {
            $requestPath = str_replace('receiptId', $this->attributeValues["receiptId"], $this->resourcePath);
        } else {
            $requestPath = $this->resourcePath . "/" . $this->attributeValues["receiptId"];
        }

        // If the request is to Resume a 3DS2 payment, move the methodCompletion to the right depth
        if (strpos($this->resourcePath, 'resume3ds') !== false
            && array_key_exists('methodCompletion', $this->attributeValues)) {
            $threeDSecure = array('methodCompletion' => $this->attributeValues['methodCompletion']);
            $this->attributeValues['threeDSecure'] = $threeDSecure;
            unset($this->attributeValues['methodCompletion']);
        }

        $response = $this->request->put(
            $requestPath,
            $this->attributeValues
        );

        return $this->getResponseArray($response);
    }


    /**
     * Validate card payment details without making a payment
     * @return array $response
     **/
    public function validate()
    {
        $this->checkApiMethodIsSupported(__FUNCTION__);
        $this->checkJudoId();
        $this->checkRequiredAttributes($this->attributeValues);

        $validateResourcePath = $this->resourcePath.'/validate';

        $response = $this->request->post(
            $validateResourcePath,
            $this->attributeValues
        );

        return $this->getResponseArray($response);
    }

    /**
     * Get a single attribute value
     * @param string $attribute Attribute name
     * @return string Attribute value
     **/
    public function getAttributeValue($attribute)
    {
        if (!array_key_exists($attribute, $this->attributeValues)) {
            return null;
        }

        return $this->attributeValues[$attribute];
    }

    /**
     * Get all attribute values
     * @return array Attribute values
     **/
    public function getAttributeValues()
    {
        return $this->attributeValues;
    }

    /**
     * Set attribute values
     * @param array $values Attribute values
     * @return void
     **/
    public function setAttributeValues($values)
    {
        foreach ($values as $key => $value) {
            // Does the attribute exist?
            if (!array_key_exists($key, $this->attributes)) {
                continue;
            }

            // Coerce to the right type if required
            $targetDataType = $this->attributes[$key];
            $this->attributeValues[$key] = DataType::coerce(
                $targetDataType,
                $value
            );
        }
    }

    /**
     * Check if the specified method name is supported by this model
     * @param string $methodName Method name
     * @return void
     **/
    protected function checkApiMethodIsSupported($methodName)
    {
        if (empty($this->validApiMethods)
            || !in_array($methodName, $this->validApiMethods)
        ) {
            throw new ValidationError('API method is not supported');
        }
    }

    /**
     * Check if request data contains all of the required attributes to create a new record
     * @param array $data Request data
     * @return bool
     */
    protected function checkRequiredAttributes($data)
    {
        $existingAttributes = array_keys($data);
        $errors = array();
        foreach ($this->requiredAttributes as $requiredAttribute) {
            if (!in_array($requiredAttribute, $existingAttributes)
                || $data[$requiredAttribute] === ''
                || $data[$requiredAttribute] === null
            ) {
                $errors[] = $requiredAttribute.' is missing or empty';
            }
        }

        if (count($errors) > 0) {
            throw new ValidationError('Missing required fields', $errors);
        }

        return true;
    }

    /**
     * If a Judo ID is not set, use the value from configuration
     * @return void
     **/
    protected function checkJudoId()
    {
        $judoId = $this->getAttributeValue(static::JUDO_ID);
        if (!empty($judoId)) {
            return;
        }

        $configuration = $this->request->getConfiguration();
        $this->attributeValues[static::JUDO_ID] = $configuration->get(static::JUDO_ID);
    }
}
