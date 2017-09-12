<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Tests\Response\ActivitiesGetResponse;

use Citilink\ExpertSenderApi\Enum\ActivitiesGetRequest\RemovalReason;
use Citilink\ExpertSenderApi\Model\ActivitiesGetResponse\RemovalActivity;
use Citilink\ExpertSenderApi\Response;
use function iter\toArray;
use PHPUnit\Framework\Assert;

/**
 * RemovalsActivityGetResponseTest
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class RemovalsActivityGetResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test
     */
    public function testGetCommonUsage()
    {
        $csv = 'Date,Email,Reason,MessageId,MessageSubject,ListId,ListName,MessageGuid
2017-06-01 06:40:00,6846253@gmail.ru,Api,89,"<if condition=""(SnippetExists(\'firstname\')) &&'
            . ' (Snippet(\'firstname\') != \'\')"">${Snippet(\'firstname\')}, c</if><else>C</else>ongrats",'
            . '81,Torl,8f5268e3-5980-473b-a369-c9b97cca0bc6
2017-06-01 15:31:00,skol@mail.com,User,26,"Subject",,15,Registration,'
            . 'db481b7d-0a2d-4b4e-a526-0f5994f71d9b';

        $response = new Response\ActivitiesGetResponse\RemovalsActivityGetResponse(
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
        /** @var RemovalActivity[] $removalActivities */
        $removalActivities = toArray($response->getRemovals());

        Assert::assertCount(2, $removalActivities);

        Assert::assertSame('2017-06-01 06:40:00', $removalActivities[0]->getDate()->format('Y-m-d H:i:s'));
        Assert::assertSame('6846253@gmail.ru', $removalActivities[0]->getEmail());
        Assert::assertSame(89, $removalActivities[0]->getMessageId());
        Assert::assertSame(
            '<if condition="(SnippetExists(\'firstname\')) &&'
            . ' (Snippet(\'firstname\') != \'\')">${Snippet(\'firstname\')}, c</if><else>C</else>ongrats',
            $removalActivities[0]->getMessageSubject()
        );
        Assert::assertSame(81, $removalActivities[0]->getListId());
        Assert::assertSame('Torl', $removalActivities[0]->getListName());
        Assert::assertSame('8f5268e3-5980-473b-a369-c9b97cca0bc6', $removalActivities[0]->getMessageGuid());
        Assert::assertTrue($removalActivities[0]->getReason()->equals(RemovalReason::API()));
    }
}
