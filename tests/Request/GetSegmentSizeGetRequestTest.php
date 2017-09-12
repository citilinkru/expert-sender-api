<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Tests\Request;

use Citilink\ExpertSenderApi\Enum\HttpMethod;
use Citilink\ExpertSenderApi\Request\GetSegmentSizeGetRequest;
use PHPUnit\Framework\Assert;

/**
 * GetSegmentSizeGetRequestTest
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class GetSegmentSizeGetRequestTest extends \PHPUnit_Framework_TestCase
{
    public function testCommonUsage()
    {
        $request = new GetSegmentSizeGetRequest(25);
        Assert::assertEquals(['id' => 25], $request->getQueryParams());
        Assert::assertTrue($request->getMethod()->equals(HttpMethod::GET()));
        Assert::assertEquals('', $request->toXml());
        Assert::assertEquals('/Api/GetSegmentSize', $request->getUri());
    }
}
