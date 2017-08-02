<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Tests\Request;

use Citilink\ExpertSenderApi\Enum\HttpMethod;
use Citilink\ExpertSenderApi\Request\TimeGetRequest;
use PHPUnit\Framework\Assert;

class TimeGetRequestTest extends \PHPUnit_Framework_TestCase
{
    public function testValidUsage()
    {
        $request = new TimeGetRequest();
        Assert::assertEquals([], $request->getQueryParams());
        Assert::assertTrue($request->getMethod()->equals(HttpMethod::GET()));
        Assert::assertEquals('/Api/Time', $request->getUri());
        Assert::assertEquals('', $request->toXml());
    }
}
