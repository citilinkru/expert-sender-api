<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Tests\Response\ActivitiesGetResponse;

use Citilink\ExpertSenderApi\Model\ActivitiesGetResponse\SubscriptionActivity;
use Citilink\ExpertSenderApi\Response;
use Citilink\ExpertSenderApi\Response\ActivitiesGetResponse\SubscriptionsActivityGetResponse;
use function iter\toArray;
use PHPUnit\Framework\Assert;

/**
 * SubscriptionsActivityGetResponseTest
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class SubscriptionsActivityGetResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test
     */
    public function testCommonUsage()
    {
        $csv = 'Date,Email,ListId,ListName
2017-02-02 00:01:00,mail@mail.com,18,Registration
2017-02-02 00:02:00,mail2@gmail.su,156,List name test';
        $response = new SubscriptionsActivityGetResponse(
            new Response(
                new \GuzzleHttp\Psr7\Response(
                    200,
                    ['Content-Type' => 'text/csv', 'Content-Length' => strlen($csv)],
                    $csv
                )
            )
        );

        Assert::assertTrue($response->isOk());
        Assert::assertFalse($response->isEmpty());
        /** @var SubscriptionActivity[] $subscriptions */
        $subscriptions = toArray($response->getSubscriptions());

        Assert::assertCount(2, $subscriptions);

        Assert::assertSame('2017-02-02 00:01:00', $subscriptions[0]->getDate()->format('Y-m-d H:i:s'));
        Assert::assertSame('mail@mail.com', $subscriptions[0]->getEmail());
        Assert::assertSame(18, $subscriptions[0]->getListId());
        Assert::assertSame('Registration', $subscriptions[0]->getListName());

        Assert::assertSame('2017-02-02 00:02:00', $subscriptions[1]->getDate()->format('Y-m-d H:i:s'));
        Assert::assertSame('mail2@gmail.su', $subscriptions[1]->getEmail());
        Assert::assertSame(156, $subscriptions[1]->getListId());
        Assert::assertSame('List name test', $subscriptions[1]->getListName());

    }
}
