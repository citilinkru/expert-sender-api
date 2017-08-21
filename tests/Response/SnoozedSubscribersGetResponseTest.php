<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Tests\Response;

use Citilink\ExpertSenderApi\Model\SnoozedSubscribersGetResponse\SnoozedSubscriber;
use Citilink\ExpertSenderApi\Response;
use Citilink\ExpertSenderApi\Response\SnoozedSubscribersGetResponse;
use function iter\toArray;
use PHPUnit\Framework\Assert;

/**
 * SnoozedSubscribersGetResponseTest
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class SnoozedSubscribersGetResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test
     */
    public function testCommonUsage()
    {
        $xml = '<ApiResponse xmlns:xsd="http://www.w3.org/2001/XMLSchema"'
            . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
          <Data>
            <SnoozedSubscribers>
              <SnoozedSubscriber>
                <Email>testsnoozed1@test123.com</Email>
                <ListId>22</ListId>
                <SnoozedUntil>2014-03-05T11:13:04Z</SnoozedUntil>
              </SnoozedSubscriber>
              <SnoozedSubscriber>
                <Email>testsnoozed2@test123.com</Email>
                <ListId>101</ListId>
                <SnoozedUntil>2014-04-28T15:09:44Z</SnoozedUntil>
              </SnoozedSubscriber>
            </SnoozedSubscribers>
          </Data>
        </ApiResponse>';
        $response = new SnoozedSubscribersGetResponse(
            new Response(
                new \GuzzleHttp\Psr7\Response(
                    200,
                    ['Content-Length' => strlen($xml), 'Content-Type' => 'text/xml'],
                    $xml
                )
            )
        );

        Assert::assertTrue($response->isOk());
        Assert::assertFalse($response->isEmpty());
        /** @var SnoozedSubscriber[] $snoozedSubscribers */
        $snoozedSubscribers = toArray($response->getSnoozedSubscribers());

        Assert::assertCount(2, $snoozedSubscribers);

        Assert::assertEquals('testsnoozed1@test123.com', $snoozedSubscribers[0]->getEmail());
        Assert::assertEquals(22, $snoozedSubscribers[0]->getListId());
        Assert::assertEquals('2014-03-05 11:13:04', $snoozedSubscribers[0]->getSnoozedUntil()->format('Y-m-d H:i:s'));

        Assert::assertEquals('testsnoozed2@test123.com', $snoozedSubscribers[1]->getEmail());
        Assert::assertEquals(101, $snoozedSubscribers[1]->getListId());
        Assert::assertEquals('2014-04-28 15:09:44', $snoozedSubscribers[1]->getSnoozedUntil()->format('Y-m-d H:i:s'));
    }
}
