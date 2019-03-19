<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Tests\Request;

use Citilink\ExpertSenderApi\Enum\HttpMethod;
use Citilink\ExpertSenderApi\Enum\RemovedSubscribersGetRequest\Option;
use Citilink\ExpertSenderApi\Enum\RemovedSubscribersGetRequest\RemoveType;
use Citilink\ExpertSenderApi\Request\RemovedSubscriberGetRequest;
use PHPUnit\Framework\Assert;

/**
 * RemovedSubscriberGetRequestTest
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class RemovedSubscriberGetRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test
     */
    public function testQueryParams()
    {
        $request = new RemovedSubscriberGetRequest(
            [1, 2, 3],
            [RemoveType::API(), RemoveType::COMPLAINT()],
            new \DateTime('2017-10-01'),
            new \DateTime('2017-10-30'),
            Option::CUSTOMS()
        );

        Assert::assertEquals(
            [
                'listIds' => '1,2,3',
                'removeTypes' => 'Api,Complaint',
                'startDate' => '2017-10-01',
                'endDate' => '2017-10-30',
                'option' => 'Customs',
            ],
            $request->getQueryParams()
        );
        Assert::assertTrue($request->getMethod()->equals(HttpMethod::GET()));
        Assert::assertEquals('/v2/Api/RemovedSubscribers', $request->getUri());
        Assert::assertEmpty($request->toXml());
    }
}
