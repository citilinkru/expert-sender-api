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

        $response = new Response(
            new \GuzzleHttp\Psr7\Response(400, ['Content-Length' => strlen($xml), 'Content-Type' => 'text/xml'], $xml)
        );
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
        $response = new Response(new \GuzzleHttp\Psr7\Response(200, [], ''));
        Assert::assertTrue($response->isOk());
        Assert::assertCount(0, $response->getErrorMessages());
        Assert::assertEmpty($response->getErrorCode());
        Assert::assertEquals(200, $response->getHttpStatusCode());
        Assert::assertEmpty($response->getContent());
    }

    /**
     * Test
     */
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

        $response = new Response(
            new \GuzzleHttp\Psr7\Response(400, ['Content-Length' => strlen($xml), 'Content-Type' => 'text/xml'], $xml)
        );
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

    /**
     * Test
     */
    public function testGetSimpleXmlAndCsv()
    {
        $content = 'Date,Email,BounceCode,BounceType' . PHP_EOL
            . '2010-10-01 17:10:00,test1@yahoo.com,some test bounce code,UserUnknown';
        $response = new Response(
            new \GuzzleHttp\Psr7\Response(
                200,
                ['Content-Length' => strlen($content), 'Content-Type' => 'text/csv'],
                $content
            )
        );

        Assert::assertTrue($response->isOk());
        Assert::assertFalse($response->isEmpty());
        Assert::assertNull($response->getErrorCode());
        Assert::assertEmpty($response->getErrorMessages());
        Assert::assertEquals(200, $response->getHttpStatusCode());
    }
}
