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
        $errorMessages = $response->getErrorMessages();
        Assert::assertCount(1, $errorMessages);
        Assert::assertEquals('Row with specified criteria doesn’t exists', $errorMessages[0]->getMessage());
        Assert::assertEquals([], $errorMessages[0]->getOptions());
        Assert::assertNotEmpty($response->getContent());
    }

    /**
     * Test
     */
    public function testEmptyResponseWithHttpOkIsOkResponse()
    {
        $response = Response::createFromString('', 200);
        Assert::assertTrue($response->isOk());
        Assert::assertCount(0, $response->getErrorMessages());
        Assert::assertEmpty($response->getErrorCode());
        Assert::assertEquals(200, $response->getHttpStatusCode());
        Assert::assertEmpty($response->getContent());
    }

    public function testMultiMessage()
    {
        $xml = '<ApiResponse xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" '
            . 'xmlns:xsd="http://www.w3.org/2001/XMLSchema">
            <ErrorMessage>
                <Code>400</Code>
                <Messages>
                    <Message for="Row 1">Row with specified criteria already exists.</Message>
                    <Message for="Row 2">Request does not contain required columns.</Message>
                    <Message for="Row 3">Row with specified criteria already exists.</Message>
                </Messages>
            </ErrorMessage>
        </ApiResponse>';

        $response = Response::createFromString($xml, 400);
        Assert::assertFalse($response->isOk());
        Assert::assertEquals(400, $response->getErrorCode());
        Assert::assertEquals(400, $response->getHttpStatusCode());
        Assert::assertNotEmpty($response->getContent());
        $errorMessages = $response->getErrorMessages();
        Assert::assertCount(3, $errorMessages);

        Assert::assertEquals('Row with specified criteria already exists.', $errorMessages[0]->getMessage());
        Assert::assertEquals('Row 1', $errorMessages[0]->getOptions()['for']);

        Assert::assertEquals('Request does not contain required columns.', $errorMessages[1]->getMessage());
        Assert::assertEquals('Row 2', $errorMessages[1]->getOptions()['for']);

        Assert::assertEquals('Row with specified criteria already exists.', $errorMessages[2]->getMessage());
        Assert::assertEquals('Row 3', $errorMessages[2]->getOptions()['for']);
    }
}
