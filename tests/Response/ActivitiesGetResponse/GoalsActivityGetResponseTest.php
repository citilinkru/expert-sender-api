<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Tests\Response\ActivitiesGetResponse;

use Citilink\ExpertSenderApi\Model\ActivitiesGetResponse\GoalActivity;
use Citilink\ExpertSenderApi\Response;
use Citilink\ExpertSenderApi\Response\ActivitiesGetResponse\GoalsActivityGetResponse;
use function iter\toArray;
use PHPUnit\Framework\Assert;

/**
 * GoalsActivityGetResponseTest
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class GoalsActivityGetResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test
     */
    public function testGetCommonUsage()
    {
        $csv = 'Date,Email,MessageId,MessageSubject,GoalValue,ListId,ListName,MessageGuid
2017-06-01 06:40:00,6846253@gmail.ru,89,"<if condition=""(SnippetExists(\'firstname\')) &&'
            . ' (Snippet(\'firstname\') != \'\')"">${Snippet(\'firstname\')}, c</if><else>C</else>ongrats",'
            . '100,81,Torl,8f5268e3-5980-473b-a369-c9b97cca0bc6
2017-06-01 15:31:00,skol@mail.com,26,"Subject",,15,Registration,'
            . 'db481b7d-0a2d-4b4e-a526-0f5994f71d9b';

        $response = new GoalsActivityGetResponse(
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
        /** @var GoalActivity[] $goalActivities */
        $goalActivities = toArray($response->getGoals());

        Assert::assertCount(2, $goalActivities);

        Assert::assertSame('2017-06-01 06:40:00', $goalActivities[0]->getDate()->format('Y-m-d H:i:s'));
        Assert::assertSame('6846253@gmail.ru', $goalActivities[0]->getEmail());
        Assert::assertSame(89, $goalActivities[0]->getMessageId());
        Assert::assertSame(
            '<if condition="(SnippetExists(\'firstname\')) &&'
            . ' (Snippet(\'firstname\') != \'\')">${Snippet(\'firstname\')}, c</if><else>C</else>ongrats',
            $goalActivities[0]->getMessageSubject()
        );
        Assert::assertSame(81, $goalActivities[0]->getListId());
        Assert::assertSame('Torl', $goalActivities[0]->getListName());
        Assert::assertSame('8f5268e3-5980-473b-a369-c9b97cca0bc6', $goalActivities[0]->getMessageGuid());
        Assert::assertSame(100, $goalActivities[0]->getGoalValue());
    }
}
