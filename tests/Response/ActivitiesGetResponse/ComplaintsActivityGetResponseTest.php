<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Tests\Response\ActivitiesGetResponse;

use Citilink\ExpertSenderApi\Model\ActivitiesGetResponse\ComplaintActivity;
use Citilink\ExpertSenderApi\Response;
use Citilink\ExpertSenderApi\Response\ActivitiesGetResponse\ComplaintsActivityGetResponse;
use function iter\toArray;
use PHPUnit\Framework\Assert;

/**
 * ComplaintsActivityGetResponseTest
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class ComplaintsActivityGetResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test
     */
    public function testGetCommonUsage()
    {
        $csv = 'Date,Email,MessageId,MessageSubject,ListId,ListName,MessageGuid
2017-06-01 06:40:00,6846253@gmail.ru,89,"<if condition=""(SnippetExists(\'firstname\')) &&'
            . ' (Snippet(\'firstname\') != \'\')"">${Snippet(\'firstname\')}, c</if><else>C</else>ongrats",'
            . '81,Torl,8f5268e3-5980-473b-a369-c9b97cca0bc6
2017-06-01 15:31:00,skol@mail.com,26,"Subject",,15,Registration,'
            . 'db481b7d-0a2d-4b4e-a526-0f5994f71d9b';

        $response = new ComplaintsActivityGetResponse(
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
        /** @var ComplaintActivity[] $complaintActivities */
        $complaintActivities = toArray($response->getComplaints());

        Assert::assertCount(2, $complaintActivities);

        Assert::assertSame('2017-06-01 06:40:00', $complaintActivities[0]->getDate()->format('Y-m-d H:i:s'));
        Assert::assertSame('6846253@gmail.ru', $complaintActivities[0]->getEmail());
        Assert::assertSame(89, $complaintActivities[0]->getMessageId());
        Assert::assertSame(
            '<if condition="(SnippetExists(\'firstname\')) &&'
            . ' (Snippet(\'firstname\') != \'\')">${Snippet(\'firstname\')}, c</if><else>C</else>ongrats',
            $complaintActivities[0]->getMessageSubject()
        );
        Assert::assertSame(81, $complaintActivities[0]->getListId());
        Assert::assertSame('Torl', $complaintActivities[0]->getListName());
        Assert::assertSame('8f5268e3-5980-473b-a369-c9b97cca0bc6', $complaintActivities[0]->getMessageGuid());
    }
}
