<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Tests;

use Citilink\ExpertSenderApi\Enum\SubscribersGetRequest\DataOption;
use Citilink\ExpertSenderApi\Event\ResponseReceivedEvent;
use Citilink\ExpertSenderApi\Model\SubscribersPostRequest\Identifier;
use Citilink\ExpertSenderApi\Model\SubscribersPostRequest\SubscriberInfo;
use Citilink\ExpertSenderApi\Request\SubscribersGetRequest;
use Citilink\ExpertSenderApi\Request\SubscribersPostRequest;
use Citilink\ExpertSenderApi\RequestSender;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\Assert;
use Symfony\Component\EventDispatcher\EventDispatcher;

/**
 * RequestSenderTest
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class RequestSenderTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test
     */
    public function testExceptionGetRequest()
    {
        $xml = '<ApiResponse xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"'
            . ' xmlns:xsd="http://www.w3.org/2001/XMLSchema">
                <ErrorMessage>
                    <Code>400</Code>
                    <Message>Row with specified criteria doesn’t exists</Message>
                </ErrorMessage>
            </ApiResponse>';
        $mockHandler = new MockHandler(
            [
                new RequestException(
                    $xml,
                    new Request('GET', '/Api/Subscribers'),
                    new Response(400, ['Content-Length' => strlen($xml), 'Content-Type' => 'text/xml'], $xml)
                ),
            ]
        );
        $handler = HandlerStack::create($mockHandler);
        $client = new Client(['handler' => $handler]);
        $eventDispatcher = new EventDispatcher();
        $receivedEventHasBeenSent = false;
        $eventDispatcher->addListener(
            'expert_sender_api.response.received',
            function (ResponseReceivedEvent $event) use (&$receivedEventHasBeenSent) {
                $receivedEventHasBeenSent = true;
                Assert::assertInstanceOf(ResponseReceivedEvent::class, $event);
            }
        );
        $requestSender = new RequestSender($client, 'api-key', $eventDispatcher);
        $apiResponse = $requestSender->send(new SubscribersGetRequest('email@email.com', DataOption::FULL()));

        Assert::assertTrue($receivedEventHasBeenSent, 'Event expert_sender_api.response.received not sent');
        Assert::assertFalse($apiResponse->isOk());
        Assert::assertFalse($apiResponse->isEmpty());
        Assert::assertEquals(400, $apiResponse->getHttpStatusCode());
        Assert::assertEquals(400, $apiResponse->getErrorCode());
        $errorMessages = $apiResponse->getErrorMessages();
        Assert::assertCount(1, $errorMessages);
        Assert::assertEquals($errorMessages[0]->getMessage(), 'Row with specified criteria doesn’t exists');
    }

    /**
     * Test
     */
    public function testPostRequest()
    {
        $container = [];
        $history = Middleware::history($container);
        $mockHandler = new MockHandler(
            [new Response(201, ['Content-Length' => 0]),]
        );
        $stack = HandlerStack::create($mockHandler);
        $stack->push($history);
        $client = new Client(['handler' => $stack]);
        $eventDispatcher = new EventDispatcher();
        $receivedEventHasBeenSent = false;
        $eventDispatcher->addListener(
            'expert_sender_api.response.received',
            function (ResponseReceivedEvent $event) use (&$receivedEventHasBeenSent) {
                $receivedEventHasBeenSent = true;
                Assert::assertInstanceOf(ResponseReceivedEvent::class, $event);
            }
        );
        $requestSender = new RequestSender($client, 'api-key', $eventDispatcher);
        $subscribers = new SubscriberInfo(Identifier::createEmail('mail@mail.com'), 25);
        $apiResponse = $requestSender->send(new SubscribersPostRequest([$subscribers]));

        Assert::assertCount(1, $container);
        /** @var Request $request */
        $request = $container[0]['request'];
        Assert::assertEquals('POST', $request->getMethod());
        Assert::assertEquals('/Api/Subscribers', $request->getUri());
        $requestXml = '<ApiRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" '
            . 'xmlns:xs="http://www.w3.org/2001/XMLSchema"><ApiKey>api-key</ApiKey><MultiData><Subscriber>'
            . '<Mode>AddAndUpdate</Mode><ListId>25</ListId><MatchingMode>Email</MatchingMode>'
            . '<Email>mail@mail.com</Email></Subscriber></MultiData></ApiRequest>';
        Assert::assertEquals($requestXml, strval($request->getBody()));

        Assert::assertTrue($receivedEventHasBeenSent, 'Event expert_sender_api.response.received not sent');
        Assert::assertTrue($apiResponse->isOk());
        Assert::assertTrue($apiResponse->isEmpty());
        Assert::assertEquals(201, $apiResponse->getHttpStatusCode());
        Assert::assertEquals(null, $apiResponse->getErrorCode());
        Assert::assertCount(0, $apiResponse->getErrorMessages());
    }
}
