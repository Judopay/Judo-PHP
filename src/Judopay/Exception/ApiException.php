<?php

namespace Judopay\Exception;

use Guzzle\Http\Message\Response;
use Judopay\Helper\ArrayHelper;

class ApiException extends \RuntimeException
{
    const CATEGORY_UNKNOWN = 0;
    const CATEGORY_REQUEST = 1;
    const CATEGORY_MODEL = 2;
    const CATEGORY_CONFIG = 3;
    const CATEGORY_PROCESSING = 4;
    const CATEGORY_EXCEPTION = 5;

    /** @var FieldError[] */
    protected $fieldErrors = [];

    /** @var int */
    protected $statusCode;

    /** @var int */
    protected $category;

    /**
     * Factory method
     * @param Response $response
     * @return static
     */
    public static function factory(Response $response)
    {
        $parsedBody = $response->json();

        $category = ArrayHelper::get($parsedBody, 'category',
            self::CATEGORY_UNKNOWN);

        $message = ArrayHelper::get($parsedBody, 'message', get_called_class());

        $errorCode = ArrayHelper::get($parsedBody, 'code', 0);

        $fieldErrors = [];
        if (isset($parsedBody['details'])) {
            foreach ($parsedBody['details'] as $rawFieldError) {
                $fieldErrors[] = new FieldError(
                    ArrayHelper::get($rawFieldError, 'message', ''),
                    ArrayHelper::get($rawFieldError, 'code', 0),
                    ArrayHelper::get($rawFieldError, 'fieldName', ''),
                    ArrayHelper::get($rawFieldError, 'detail')
                );
            }
        }

        $statusCode = $response->getStatusCode();

        return new static(
            $message,
            $errorCode,
            $statusCode,
            $category,
            $fieldErrors
        );
    }

    /**
     * ApiException constructor.
     * @param string       $message User message
     * @param int          $code Error code
     * @param int          $statusCode HTTP status code
     * @param int          $category Error category
     * @param FieldError[] $fieldErrors Fields errors
     */
    public function __construct(
        $message,
        $code = 0,
        $statusCode = 0,
        $category = self::CATEGORY_UNKNOWN,
        $fieldErrors = []
    ) {
        $this->message = $message;
        $this->code = $code;
        $this->statusCode = $statusCode;
        $this->category = $category;
        $this->fieldErrors = $fieldErrors;
    }

    /**
     * Summary of the error
     * @return string
     */
    public function getSummary()
    {
        return "JudoPay ApiException (status code {$this->getHttpStatusCode()}, error code {$this->getCode()}, category {$this->getCategory()}) {$this->getMessage()}{$this->getDetailsSummary()}";
    }

    /**
     * @inheritdoc
     */
    public function __toString()
    {
        return $this->getSummary();
    }

    /**
     * HTTP status code of error
     * @return int
     */
    public function getHttpStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Error category
     * @return int
     */
    public function getCategory()
    {
        return $this->category;
    }

    protected function getDetailsSummary()
    {
        return empty($this->details)
            ? ""
            : ' Fields errors: '.PHP_EOL.join(PHP_EOL, $this->details);
    }

    /**
     * @return FieldError[]
     */
    public function getFieldErrors()
    {
        return $this->fieldErrors;
    }
}
