<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Tests\Response;

use Citilink\ExpertSenderApi\Response;
use Citilink\ExpertSenderApi\Response\TimeGetResponse;
use PHPUnit\Framework\Assert;

class TimeGetResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test
     */
    public function testNormalDateShouldWorkFine()
    {
        $body = '<ApiResponse xmlns:xsd="http://www.w3.org/2001/XMLSchema" '
            . 'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
            <Data>2013-04-24T10:33:09.4338472Z</Data>
            </ApiResponse>';

        $response = new TimeGetResponse(Response::createFromString($body, 200));
        Assert::assertTrue($response->isOk());
        Assert::assertEquals('2013-04-24T10:33:09', $response->getServerTime()->format('Y-m-d\TH:i:s'));
        Assert::assertEquals(200, $response->getHttpStatusCode());
        Assert::assertNull($response->getErrorMessage());
        Assert::assertNull($response->getErrorCode());
    }

    /**
     * Test
     *
     * @expectedException \Citilink\ExpertSenderApi\Exception\ParseResponseException
     */
    public function testThrowExceptionWhenDataIsEmpty()
    {
        $body = '<ApiResponse xmlns:xsd="http://www.w3.org/2001/XMLSchema" '
            . 'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
            <Data></Data>
            </ApiResponse>';

        $response = new TimeGetResponse(Response::createFromString($body, 200));

        Assert::assertTrue($response->isOk());
        Assert::assertEquals(200, $response->getHttpStatusCode());
        $response->getServerTime();
    }

    /**
     * Test
     *
     * @expectedException \Citilink\ExpertSenderApi\Exception\ParseResponseException
     */
    public function testThrowExceptionIfDateStringIsWrong()
    {
        $body = '<ApiResponse xmlns:xsd="http://www.w3.org/2001/XMLSchema" '
            . 'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
            <Data>WRONG_DATA</Data>
            </ApiResponse>';

        $response = new TimeGetResponse(Response::createFromString($body, 200));
        Assert::assertTrue($response->isOk());
        Assert::assertEquals('2013-04-24T10:33:09', $response->getServerTime()->format('Y-m-d\TH:i:s'));
        Assert::assertEquals(200, $response->getHttpStatusCode());
    }

    /**
     * Test
     *
     * @expectedException \Citilink\ExpertSenderApi\Exception\TryToAccessDataFromErrorResponseException
     */
    public function testThrowExceptionIfTryingGetServerTimeOnNotOkResponse()
    {
        $response = new TimeGetResponse(Response::createFromString('', 500));
        $response->getServerTime();
    }
}
