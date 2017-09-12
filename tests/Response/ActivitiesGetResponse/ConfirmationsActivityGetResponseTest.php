<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Tests\Response\ActivitiesGetResponse;

use Citilink\ExpertSenderApi\Model\ActivitiesGetResponse\ConfirmationActivity;
use Citilink\ExpertSenderApi\Response;
use Citilink\ExpertSenderApi\Response\ActivitiesGetResponse\ConfirmationsActivityGetResponse;
use function iter\toArray;
use PHPUnit\Framework\Assert;

/**
 * SubscriptionsActivityGetResponseTest
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class ConfirmationsActivityGetResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test
     */
    public function testCommonUsage()
    {
        $csv = 'Date,Email,ListId,ListName
2017-02-02 00:01:00,mail@mail.com,18,Registration
2017-02-02 00:02:00,mail2@gmail.su,156,List name test';
        $response = new ConfirmationsActivityGetResponse(
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
        /** @var ConfirmationActivity[] $confirmations */
        $confirmations = toArray($response->getConfirmations());

        Assert::assertCount(2, $confirmations);

        Assert::assertSame('2017-02-02 00:01:00', $confirmations[0]->getDate()->format('Y-m-d H:i:s'));
        Assert::assertSame('mail@mail.com', $confirmations[0]->getEmail());
        Assert::assertSame(18, $confirmations[0]->getListId());
        Assert::assertSame('Registration', $confirmations[0]->getListName());

        Assert::assertSame('2017-02-02 00:02:00', $confirmations[1]->getDate()->format('Y-m-d H:i:s'));
        Assert::assertSame('mail2@gmail.su', $confirmations[1]->getEmail());
        Assert::assertSame(156, $confirmations[1]->getListId());
        Assert::assertSame('List name test', $confirmations[1]->getListName());

    }
}
