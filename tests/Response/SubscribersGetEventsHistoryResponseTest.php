<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Tests\Response;

use Citilink\ExpertSenderApi\Model\SubscribersGetResponse\Event;
use Citilink\ExpertSenderApi\Response;
use Citilink\ExpertSenderApi\Response\SubscribersGetEventsHistoryResponse;
use PHPUnit\Framework\Assert;

/**
 * SubscribersGetEventsHistoryResponseTest
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class SubscribersGetEventsHistoryResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test
     */
    public function testCommonResponse()
    {
        $xml = '<ApiResponse xmlns:xsd="http://www.w3.org/2001/XMLSchema" '
            . 'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
          <Data>
            <Events>
              <Event>
                <StartDate>2015-01-25T10:00:00</StartDate>
                <EndDate>2015-01-25T11:00:00</EndDate>
                <MessageType>Newsletter</MessageType>
                <EventType>Click</EventType>
                <EventCount>1</EventCount>
                <MessageId>120540</MessageId>
                <MessageSubject>test some</MessageSubject>
              </Event>
              <Event>
                <StartDate>2016-01-25T10:00:00</StartDate>
                <EndDate>2016-01-25T11:00:00</EndDate>
                <MessageType>Autoresponder</MessageType>
                <EventType>Bounce</EventType>
                <EventCount>1</EventCount>
                <MessageId>120541</MessageId>
                <MessageSubject>test some some</MessageSubject>
              </Event>
            </Events>
          </Data>
        </ApiResponse>';

        $response = new SubscribersGetEventsHistoryResponse(Response::createFromString($xml, 200));
        Assert::assertTrue($response->isOk());
        Assert::assertFalse($response->isEmpty());
        /** @var Event[] $events */
        $events = iterator_to_array($response->getEvents());
        Assert::assertCount(2, $events);

        Assert::assertEquals('2015-01-25 10:00:00', $events[0]->getStartDate()->format('Y-m-d H:i:s'));
        Assert::assertEquals('2015-01-25 11:00:00', $events[0]->getEndDate()->format('Y-m-d H:i:s'));
        Assert::assertEquals('Newsletter', $events[0]->getMessageType());
        Assert::assertEquals('Click', $events[0]->getEventType());
        Assert::assertEquals(1, $events[0]->getEventCount());
        Assert::assertEquals(120540, $events[0]->getMessageId());
        Assert::assertEquals('test some', $events[0]->getMessageSubject());

        Assert::assertEquals('2016-01-25 10:00:00', $events[1]->getStartDate()->format('Y-m-d H:i:s'));
        Assert::assertEquals('2016-01-25 11:00:00', $events[1]->getEndDate()->format('Y-m-d H:i:s'));
        Assert::assertEquals('Autoresponder', $events[1]->getMessageType());
        Assert::assertEquals('Bounce', $events[1]->getEventType());
        Assert::assertEquals(1, $events[1]->getEventCount());
        Assert::assertEquals(120541, $events[1]->getMessageId());
        Assert::assertEquals('test some some', $events[1]->getMessageSubject());
    }
}
