<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Tests\Response\ActivitiesGetResponse;

use Citilink\ExpertSenderApi\Enum\ActivitiesGetRequest\BounceReason;
use Citilink\ExpertSenderApi\Model\ActivitiesGetResponse\BounceActivity;
use Citilink\ExpertSenderApi\Response;
use Citilink\ExpertSenderApi\Response\ActivitiesGetResponse\BouncesActivityGetResponse;
use function iter\toArray;
use PHPUnit\Framework\Assert;

/**
 * BouncesActivityGetResponseTest
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class BouncesActivityGetResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test
     */
    public function testGetCommonUsage()
    {
        $csv = 'Date,Email,Reason,DiagnosticCode,ListId,ListName,MessageGuid
2017-06-01 06:40:00,6846253@gmail.ru,Blocked,diagnostic_code,'
            . '81,Torl,8f5268e3-5980-473b-a369-c9b97cca0bc6
2017-06-01 15:31:00,skol@mail.com,Blocked,diagnostic_code,,15,Registration,'
            . 'db481b7d-0a2d-4b4e-a526-0f5994f71d9b';

        $response = new BouncesActivityGetResponse(
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
        /** @var BounceActivity[] $bounceActivities */
        $bounceActivities = toArray($response->getBounces());

        Assert::assertCount(2, $bounceActivities);

        Assert::assertSame('2017-06-01 06:40:00', $bounceActivities[0]->getDate()->format('Y-m-d H:i:s'));
        Assert::assertSame('6846253@gmail.ru', $bounceActivities[0]->getEmail());
        Assert::assertSame(81, $bounceActivities[0]->getListId());
        Assert::assertSame('Torl', $bounceActivities[0]->getListName());
        Assert::assertSame('8f5268e3-5980-473b-a369-c9b97cca0bc6', $bounceActivities[0]->getMessageGuid());
        Assert::assertTrue($bounceActivities[0]->getReason()->equals(BounceReason::BLOCKED()));
        Assert::assertSame('diagnostic_code', $bounceActivities[0]->getDiagnosticCode());
    }
}
