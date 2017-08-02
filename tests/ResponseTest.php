<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Tests;

use Citilink\ExpertSenderApi\Response;
use PHPUnit\Framework\Assert;

/**
 * ResponseTest
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class ResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test
     */
    public function testCommonErrorMessage()
    {
        $xml = '<ApiResponse xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"'
            . ' xmlns:xsd="http://www.w3.org/2001/XMLSchema">
                <ErrorMessage>
                    <Code>400</Code>
                    <Message>Row with specified criteria doesn’t exists</Message>
                </ErrorMessage>
            </ApiResponse>';

        $response = Response::createFromString($xml, 400);
        Assert::assertFalse($response->isOk());
        Assert::assertEquals(400, $response->getErrorCode());
        Assert::assertEquals(400, $response->getHttpStatusCode());
        Assert::assertEquals('Row with specified criteria doesn’t exists', $response->getErrorMessage());
        Assert::assertNotEmpty($response->getContent());
    }

    /**
     * Test
     */
    public function testEmptyResponseWithHttpOkIsOkResponse()
    {
        $response = Response::createFromString('', 200);
        Assert::assertTrue($response->isOk());
        Assert::assertEmpty($response->getErrorMessage());
        Assert::assertEmpty($response->getErrorCode());
        Assert::assertEquals(200, $response->getHttpStatusCode());
        Assert::assertEmpty($response->getContent());
    }
}
