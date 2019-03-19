<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Tests\Request;

use Citilink\ExpertSenderApi\Enum\HttpMethod;
use Citilink\ExpertSenderApi\Request\DataTablesClearTableRequest;
use PHPUnit\Framework\Assert;

/**
 * DataTablesClearTableRequestTest
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class DataTablesClearTableRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test
     */
    public function testCommonUsage()
    {
        $request = new DataTablesClearTableRequest('table-name');
        Assert::assertEquals([], $request->getQueryParams());
        Assert::assertEquals('/v2/Api/DataTablesClearTable', $request->getUri());
        Assert::assertTrue($request->getMethod()->equals(HttpMethod::POST()));
        Assert::assertEquals('<TableName>table-name</TableName>', $request->toXml());
    }
}
