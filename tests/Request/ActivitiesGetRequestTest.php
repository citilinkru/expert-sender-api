<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Tests\Request;

use Citilink\ExpertSenderApi\Enum\ActivitiesGetRequest\ActivityType;
use Citilink\ExpertSenderApi\Enum\ActivitiesGetRequest\ReturnColumnsSet;
use Citilink\ExpertSenderApi\Enum\HttpMethod;
use Citilink\ExpertSenderApi\Request\ActivitiesGetRequest;
use PHPUnit\Framework\Assert;

/**
 * ActivitiesGetRequestTest
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class ActivitiesGetRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test
     */
    public function testCommonUsage()
    {
        $request = new ActivitiesGetRequest(
            new \DateTime('2017-05-27'),
            ActivityType::COMPLAINTS(),
            ReturnColumnsSet::EXTENDED(),
            true,
            true
        );

        Assert::assertEquals('/v2/Api/Activities', $request->getUri());
        Assert::assertEquals(
            [
                'date' => '2017-05-27',
                'type' => 'Complaints',
                'columns' => 'Extended',
                'returnTitle' => 'true',
                'returnGuid' => 'true',
            ],
            $request->getQueryParams()
        );
        Assert::assertEquals('', $request->toXml());
        Assert::assertTrue($request->getMethod()->equals(HttpMethod::GET()));
    }
}
