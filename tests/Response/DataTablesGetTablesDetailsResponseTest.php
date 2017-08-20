<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Tests\Response;

use Citilink\ExpertSenderApi\Model\DataTablesGetTablesSummaryResponse\TableColumnData;
use Citilink\ExpertSenderApi\Response;
use Citilink\ExpertSenderApi\Response\DataTablesGetTablesDetailsResponse;
use function iter\toArray;
use PHPUnit\Framework\Assert;

class DataTablesGetTablesDetailsResponseTest extends \PHPUnit_Framework_TestCase
{
    public function testCommonUsage()
    {
        $xml = '<ApiResponse xmlns:xsd="http://www.w3.org/2001/XMLSchema"'
            . ' xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
          <Details>
             <Id>1</Id>
             <Name>Table1</Name>
             <ColumnsCount>7</ColumnsCount>
             <RelationshipsCount>10</RelationshipsCount>
             <RelationshipsDestinationCount>13</RelationshipsDestinationCount>
             <Rows>114</Rows>
             <Description>Table1 description</Description>
             <Columns>
                <TableColumn>
                   <Name>Column1</Name>
                   <ColumnType>String</ColumnType>
                   <Length>4000</Length>
                   <DefaultValue>test</DefaultValue>
                   <IsPrimaryKey>true</IsPrimaryKey>
                </TableColumn>
                <TableColumn>
                   <Name>Column2</Name>
                   <ColumnType>Number</ColumnType>
                   <Length>0</Length>
                   <IsRequired>true</IsRequired>
                </TableColumn>
                <TableColumn>
                   <Name>Column3</Name>
                   <ColumnType>Number</ColumnType>
                   <Length>0</Length>
                </TableColumn>
                <TableColumn>
                   <Name>Column4</Name>
                   <ColumnType>Date</ColumnType>
                   <Length>0</Length>
                   <DefaultValue>2012-11-20</DefaultValue>
                </TableColumn>
                <TableColumn>
                   <Name>Column5</Name>
                   <ColumnType>DateTime</ColumnType>
                   <Length>0</Length>
                   <DefaultValue>2012-11-20 11:08:33.565</DefaultValue>
                </TableColumn>
                <TableColumn>
                   <Name>Column6</Name>
                   <ColumnType>Boolean</ColumnType>
                   <Length>0</Length>
                   <DefaultValue>False</DefaultValue>
                </TableColumn>
                <TableColumn>
                   <Name>Column7</Name>
                   <ColumnType>Double</ColumnType>
                   <Length>0</Length>
                </TableColumn>
                <TableColumn>
                   <Name>Column8</Name>
                   <ColumnType>SubscriberEmail</ColumnType>
                   <Length>0</Length>
                </TableColumn>
             </Columns>
          </Details>
        </ApiResponse>';

        $response = new DataTablesGetTablesDetailsResponse(
            new Response(
                new \GuzzleHttp\Psr7\Response(
                    200,
                    ['Content-Length' => strlen($xml), 'Content-Type' => 'text/xml'],
                    $xml
                )
            )
        );

        $details = $response->getDetails();
        Assert::assertEquals(1, $details->getId());
        Assert::assertEquals('Table1', $details->getName());
        Assert::assertEquals(7, $details->getColumnsCount());
        Assert::assertEquals(10, $details->getRelationshipsCount());
        Assert::assertEquals(13, $details->getRelationshipsDestinationCount());
        Assert::assertEquals(114, $details->getRowsCount());
        Assert::assertEquals('Table1 description', $details->getDescription());

        /** @var TableColumnData[] $columns */
        $columns = toArray($details->getColumns());
        Assert::assertEquals('Column1', $columns[0]->getName());
        Assert::assertEquals('String', $columns[0]->getColumnType());
        Assert::assertEquals(4000, $columns[0]->getLength());
        Assert::assertEquals('test', $columns[0]->getDefaultValue());
        Assert::assertTrue($columns[0]->isPrimaryKey());
        Assert::assertFalse($columns[0]->isRequired());

        Assert::assertEquals('Column2', $columns[1]->getName());
        Assert::assertEquals('Number', $columns[1]->getColumnType());
        Assert::assertEquals(0, $columns[1]->getLength());
        Assert::assertNull($columns[1]->getDefaultValue());
        Assert::assertFalse($columns[1]->isPrimaryKey());
        Assert::assertTrue($columns[1]->isRequired());

        Assert::assertEquals('Column3', $columns[2]->getName());
        Assert::assertEquals('Number', $columns[2]->getColumnType());
        Assert::assertEquals(0, $columns[2]->getLength());
        Assert::assertNull($columns[2]->getDefaultValue());
        Assert::assertFalse($columns[2]->isPrimaryKey());
        Assert::assertFalse($columns[2]->isRequired());

        Assert::assertEquals('Column4', $columns[3]->getName());
        Assert::assertEquals('Date', $columns[3]->getColumnType());
        Assert::assertEquals(0, $columns[3]->getLength());
        Assert::assertEquals('2012-11-20', $columns[3]->getDefaultValue());
        Assert::assertFalse($columns[3]->isPrimaryKey());
        Assert::assertFalse($columns[3]->isRequired());

        Assert::assertEquals('Column5', $columns[4]->getName());
        Assert::assertEquals('DateTime', $columns[4]->getColumnType());
        Assert::assertEquals(0, $columns[4]->getLength());
        Assert::assertEquals('2012-11-20 11:08:33.565', $columns[4]->getDefaultValue());
        Assert::assertFalse($columns[4]->isPrimaryKey());
        Assert::assertFalse($columns[4]->isRequired());

        Assert::assertEquals('Column6', $columns[5]->getName());
        Assert::assertEquals('Boolean', $columns[5]->getColumnType());
        Assert::assertEquals(0, $columns[5]->getLength());
        Assert::assertEquals('False', $columns[5]->getDefaultValue());
        Assert::assertFalse($columns[5]->isPrimaryKey());
        Assert::assertFalse($columns[5]->isRequired());

        Assert::assertEquals('Column7', $columns[6]->getName());
        Assert::assertEquals('Double', $columns[6]->getColumnType());
        Assert::assertEquals(0, $columns[6]->getLength());
        Assert::assertNull($columns[6]->getDefaultValue());
        Assert::assertFalse($columns[6]->isPrimaryKey());
        Assert::assertFalse($columns[6]->isRequired());

        Assert::assertEquals('Column8', $columns[7]->getName());
        Assert::assertEquals('SubscriberEmail', $columns[7]->getColumnType());
        Assert::assertEquals(0, $columns[7]->getLength());
        Assert::assertNull($columns[7]->getDefaultValue());
        Assert::assertFalse($columns[7]->isPrimaryKey());
        Assert::assertFalse($columns[7]->isRequired());

    }
}
