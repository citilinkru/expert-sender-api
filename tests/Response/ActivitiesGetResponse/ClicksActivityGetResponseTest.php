<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Tests\Response\ActivitiesGetResponse;

use Citilink\ExpertSenderApi\Model\ActivitiesGetResponse\ClickActivity;
use Citilink\ExpertSenderApi\Response;
use Citilink\ExpertSenderApi\Response\ActivitiesGetResponse\ClicksActivityGetResponse;
use function iter\toArray;
use PHPUnit\Framework\Assert;

/**
 * ClicksActivityGetResponseTest
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class ClicksActivityGetResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test
     */
    public function testGetCommonUsage()
    {
        $csv = 'Date,Email,MessageId,MessageSubject,Url,Title,ListId,ListName,MessageGuid
2017-06-01 06:40:00,6846253@gmail.ru,89,"<if condition=""(SnippetExists(\'firstname\')) &&'
            . ' (Snippet(\'firstname\') != \'\')"">${Snippet(\'firstname\')}, c</if><else>C</else>ongrats",'
            . 'http://www.google.com/,,81,Torl,8f5268e3-5980-473b-a369-c9b97cca0bc6
2017-06-01 15:31:00,skol@mail.com,26,"Subject",http://mail.google.com/,,15,Registration,'
            . 'db481b7d-0a2d-4b4e-a526-0f5994f71d9b';

        $response = new ClicksActivityGetResponse(
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
        /** @var ClickActivity[] $clicks */
        $clicks = toArray($response->getClicks());

        Assert::assertCount(2, $clicks);

        Assert::assertSame('2017-06-01 06:40:00', $clicks[0]->getDate()->format('Y-m-d H:i:s'));
        Assert::assertSame('6846253@gmail.ru', $clicks[0]->getEmail());
        Assert::assertSame(89, $clicks[0]->getMessageId());
        Assert::assertSame(
            '<if condition="(SnippetExists(\'firstname\')) &&'
            . ' (Snippet(\'firstname\') != \'\')">${Snippet(\'firstname\')}, c</if><else>C</else>ongrats',
            $clicks[0]->getMessageSubject()
        );
        Assert::assertSame('http://www.google.com/', $clicks[0]->getUrl());
        Assert::assertSame('', $clicks[0]->getTitle());
        Assert::assertSame(81, $clicks[0]->getListId());
        Assert::assertSame('Torl', $clicks[0]->getListName());
        Assert::assertSame('8f5268e3-5980-473b-a369-c9b97cca0bc6', $clicks[0]->getMessageGuid());
    }
}
