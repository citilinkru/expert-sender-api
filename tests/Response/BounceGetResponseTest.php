<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Tests\Response;

use Citilink\ExpertSenderApi\Model\BouncesGetResponse\Bounce;
use Citilink\ExpertSenderApi\Response;
use Citilink\ExpertSenderApi\Response\BouncesGetResponse;
use PHPUnit\Framework\Assert;

/**
 * BounceGetResponseTest
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class BounceGetResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test
     */
    public function testCommonExample()
    {
        $csv = 'Date,Email,BounceCode,BounceType' . PHP_EOL
            . '2010-10-01 17:10:00,test1@yahoo.com,some test bounce code,UserUnknown' . PHP_EOL
            . '2010-10-01 17:10:00,test2@yahoo.com,some test bounce code 1,MailboxFull' . PHP_EOL;

        $response = new BouncesGetResponse(
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
        Assert::assertNull($response->getErrorCode());
        Assert::assertEmpty($response->getErrorMessages());

        /** @var Bounce[] $bounces */
        $bounces = iterator_to_array($response->getBounces());

        Assert::assertCount(2, $bounces);
        Assert::assertEquals('2010-10-01 17:10:00', $bounces[0]->getDate()->format('Y-m-d H:i:s'));
        Assert::assertEquals('test1@yahoo.com', $bounces[0]->getEmail());
        Assert::assertEquals('some test bounce code', $bounces[0]->getBounceCode());
        Assert::assertEquals('UserUnknown', $bounces[0]->getBounceType());

        Assert::assertEquals('2010-10-01 17:10:00', $bounces[1]->getDate()->format('Y-m-d H:i:s'));
        Assert::assertEquals('test2@yahoo.com', $bounces[1]->getEmail());
        Assert::assertEquals('some test bounce code 1', $bounces[1]->getBounceCode());
        Assert::assertEquals('MailboxFull', $bounces[1]->getBounceType());
    }
}
