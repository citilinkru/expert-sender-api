<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Tests\Response\ActivitiesGetResponse;

use Citilink\ExpertSenderApi\Model\ActivitiesGetResponse\SendActivity;
use Citilink\ExpertSenderApi\Response;
use Citilink\ExpertSenderApi\Response\ActivitiesGetResponse\SendsActivityGetResponse;
use function iter\toArray;
use PHPUnit\Framework\Assert;

/**
 * SendsActivityGetResponseTest
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class SendsActivityGetResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test
     */
    public function testCommonUsage()
    {
        $csv = 'Date,Email,MessageId,MessageSubject,ListId,ListName,MessageGuid
2017-06-01 11:51:00,some@mail.ru,126,"<if condition=""(SnippetExists(\'firstname\')) && (Snippet(\'firstname\')'
            . ' != \'\')"">${Snippet(\'firstname\')}, c</if><else>C</else>ongrats!",28,Congrats,'
            . '5f476666-8b86-492c-8102-fba0d0aaf7db
2017-06-01 11:52:00,ps@gmail.ru,226,"Subject",151,Some action,67331a21-a384-4215-bede-019112548619';

        $response = new SendsActivityGetResponse(
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
        /** @var SendActivity[] $sends */
        $sends = toArray($response->getSends());

        Assert::assertCount(2, $sends);

        Assert::assertSame('2017-06-01 11:51:00', $sends[0]->getDate()->format('Y-m-d H:i:s'));
        Assert::assertSame('some@mail.ru', $sends[0]->getEmail());
        Assert::assertSame(
            '<if condition="(SnippetExists(\'firstname\')) && (Snippet(\'firstname\')'
            . ' != \'\')">${Snippet(\'firstname\')}, c</if><else>C</else>ongrats!',
            $sends[0]->getMessageSubject()
        );
        Assert::assertSame(126, $sends[0]->getMessageId());
        Assert::assertSame(28, $sends[0]->getListId());
        Assert::assertSame('Congrats', $sends[0]->getListName());
        Assert::assertSame('5f476666-8b86-492c-8102-fba0d0aaf7db', $sends[0]->getMessageGuid());

        Assert::assertSame('2017-06-01 11:52:00', $sends[1]->getDate()->format('Y-m-d H:i:s'));
        Assert::assertSame('ps@gmail.ru', $sends[1]->getEmail());
        Assert::assertSame(
            'Subject',
            $sends[1]->getMessageSubject()
        );
        Assert::assertSame(226, $sends[1]->getMessageId());
        Assert::assertSame(151, $sends[1]->getListId());
        Assert::assertSame('Some action', $sends[1]->getListName());
        Assert::assertSame('67331a21-a384-4215-bede-019112548619', $sends[1]->getMessageGuid());
    }
}
