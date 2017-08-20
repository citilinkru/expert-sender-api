<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Tests\Request;

use Citilink\ExpertSenderApi\Enum\DataTablesDeleteRowsPostRequest\FilterOperator;
use Citilink\ExpertSenderApi\Enum\HttpMethod;
use Citilink\ExpertSenderApi\Model\DataTablesDeleteRowsPostRequest\Filter;
use Citilink\ExpertSenderApi\Request\DataTablesDeleteRowsPostRequest;
use PHPUnit\Framework\Assert;

/**
 * DataTablesDeleteRowsPostRequestTest
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class DataTablesDeleteRowsPostRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test
     */
    public function testCommonUsage()
    {
        $request = new DataTablesDeleteRowsPostRequest(
            'table-name',
            [
                new Filter('Column1', FilterOperator::EQ(), 12),
                new Filter('Column2', FilterOperator::GE(), 56.7),
                new Filter('Column3', FilterOperator::EQ(), 'string'),
                new Filter('Column4', FilterOperator::GT(), 89.234),
                new Filter('Column5', FilterOperator::LT(), 87.3),
                new Filter('Column6', FilterOperator::LE(), 98),
            ]
        );

        Assert::assertEquals([], $request->getQueryParams());
        Assert::assertEquals('/Api/DataTablesDeleteRows/', $request->getUri());
        Assert::assertTrue($request->getMethod()->equals(HttpMethod::POST()));
        Assert::assertEquals(
            '<TableName>table-name</TableName><Filters><Filter><Column><Name>Column1</Name>'
            . '<Operator>EQ</Operator><Value>12</Value></Column></Filter><Filter><Column><Name>Column2</Name>'
            . '<Operator>GE</Operator><Value>56.7</Value></Column></Filter><Filter><Column><Name>Column3</Name>'
            . '<Operator>EQ</Operator><Value>string</Value></Column></Filter><Filter><Column><Name>Column4</Name>'
            . '<Operator>GT</Operator><Value>89.234</Value></Column></Filter><Filter><Column><Name>Column5</Name>'
            . '<Operator>LT</Operator><Value>87.3</Value></Column></Filter><Filter><Column><Name>Column6</Name>'
            . '<Operator>LE</Operator><Value>98</Value></Column></Filter></Filters>',
            $request->toXml()
        );
    }
}
