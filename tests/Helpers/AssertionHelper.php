<?php

namespace Tests\Helpers;

use PHPUnit_Framework_Assert as Assert;

/**
 * @author Oleg Fetisov <ofetisov@corevalue.net>
 */
class AssertionHelper
{
    public static function assertApiExceptionWithModelErrors(
        $apiException,
        $numberOfModelErrorsExpected,
        $errorCode,
        $statusCode = 400,
        $errorCategory = 2
    ) {
        /** @var \Judopay\Exception\ApiException $apiException */
        Assert::assertInstanceOf(
            '\Judopay\Exception\ApiException',
            $apiException
        );

        Assert::assertCount(
            $numberOfModelErrorsExpected,
            $apiException->getFieldErrors()
        );

        Assert::assertEquals($errorCode, $apiException->getCode());
        Assert::assertEquals($statusCode, $apiException->getHttpStatusCode());
        Assert::assertEquals($errorCategory, $apiException->getCategory());
    }
}
