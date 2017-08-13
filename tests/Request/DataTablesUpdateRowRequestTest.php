<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Tests\Request;

use Citilink\ExpertSenderApi\Enum\HttpMethod;
use Citilink\ExpertSenderApi\Model\Column;
use Citilink\ExpertSenderApi\Request\DataTablesUpdateRowPostRequest;
use PHPUnit\Framework\Assert;

class DataTablesUpdateRowRequestTest extends \PHPUnit_Framework_TestCase
{
    public function testCommonUsage()
    {
        $request = new DataTablesUpdateRowPostRequest(
            'table-name',
            [
                new Column('Column1', 12),
                new Column('Column2', 12.5),
                new Column('Column3', 'string'),
            ],
            [
                new Column('Column4', 15),
                new Column('Column5', 15.8),
                new Column('Column6', 'string2'),
                new Column('Column7', null),
            ]
        );

        $xml = '<TableName>table-name</TableName><PrimaryKeyColumns><Column><Name>Column1</Name><Value>12</Value>'
            . '</Column><Column><Name>Column2</Name><Value>12.5</Value></Column><Column><Name>Column3</Name>'
            . '<Value>string</Value></Column></PrimaryKeyColumns><Columns><Column><Name>Column4</Name>'
            . '<Value>15</Value></Column><Column><Name>Column5</Name><Value>15.8</Value></Column><Column>'
            . '<Name>Column6</Name><Value>string2</Value></Column><Column><Name>Column7</Name><Value xsi:nil="true"/>'
            . '</Column></Columns>';
        Assert::assertEquals($xml, $request->toXml());
        Assert::assertEquals([], $request->getQueryParams());
        Assert::assertTrue($request->getMethod()->equals(HttpMethod::POST()));
        Assert::assertEquals('/Api/DataTablesUpdateRow', $request->getUri());
    }
}
