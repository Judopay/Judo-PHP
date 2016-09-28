<?php

namespace Tests\Helpers;

use PHPUnit_Framework_Assert as Assert;

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

    public static function assertSuccessfulPayment($result)
    {
        Assert::assertNotNull($result);
        Assert::assertEquals('Success', $result['result']);
        Assert::assertGreaterThan(0, $result['receiptId']);
    }

    public static function assertDeclinedPayment($result)
    {
        Assert::assertNotNull($result);
        Assert::assertEquals('Declined', $result['result']);
        Assert::assertGreaterThan(0, $result['receiptId']);
    }
}
