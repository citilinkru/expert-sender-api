<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Tests\Response;

use Citilink\ExpertSenderApi\Model\DataTablesGetTablesSummaryResponse\TableSummary;
use Citilink\ExpertSenderApi\Response;
use Citilink\ExpertSenderApi\Response\DataTablesGetTablesSummaryResponse;
use function iter\toArray;
use PHPUnit\Framework\Assert;

/**
 * DataTablesGetTablesSummaryResponseTest
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class DataTablesGetTablesSummaryResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test
     */
    public function testCommonUsage()
    {
        $xml = '<ApiResponse xmlns:xsd="http://www.w3.org/2001/XMLSchema" '
            . 'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
           <TableList>
              <Tables>
                 <Table>
                    <Id>1</Id>
                    <Name>Table1</Name>
                    <ColumnsCount>8</ColumnsCount>
                    <RelationshipsCount>0</RelationshipsCount>
                    <RelationshipsDestinationCount>1</RelationshipsDestinationCount>
                    <Rows>5</Rows>
                    <Size>0.05</Size>
                 </Table>
                 <Table>
                    <Id>2</Id>
                    <Name>Table2</Name>
                    <ColumnsCount>15</ColumnsCount>
                    <RelationshipsCount>3</RelationshipsCount>
                    <RelationshipsDestinationCount>4</RelationshipsDestinationCount>
                    <Rows>5</Rows>
                    <Size>1.09</Size>
                 </Table>
              </Tables>
           </TableList>
        </ApiResponse>';
        $response = new DataTablesGetTablesSummaryResponse(
            new Response(
                new \GuzzleHttp\Psr7\Response(
                    200,
                    ['Content-Length' => strlen($xml), 'Content-Type' => 'text/xml'],
                    $xml
                )
            )
        );

        Assert::assertTrue($response->isOk());
        Assert::assertFalse($response->isEmpty());
        Assert::assertEquals(200, $response->getHttpStatusCode());
        /** @var TableSummary[] $tables */
        $tables = toArray($response->getTables());
        Assert::assertCount(2, $tables);
        Assert::assertEquals(1, $tables[0]->getId());
        Assert::assertEquals('Table1', $tables[0]->getName());
        Assert::assertEquals(8, $tables[0]->getColumnsCount());
        Assert::assertEquals(0, $tables[0]->getRelationshipsCount());
        Assert::assertEquals(1, $tables[0]->getRelationshipsDestinationCount());
        Assert::assertEquals(5, $tables[0]->getRowsCount());
        Assert::assertEquals(0.05, $tables[0]->getSize());

        Assert::assertEquals(2, $tables[1]->getId());
        Assert::assertEquals('Table2', $tables[1]->getName());
        Assert::assertEquals(15, $tables[1]->getColumnsCount());
        Assert::assertEquals(3, $tables[1]->getRelationshipsCount());
        Assert::assertEquals(4, $tables[1]->getRelationshipsDestinationCount());
        Assert::assertEquals(5, $tables[1]->getRowsCount());
        Assert::assertEquals(1.09, $tables[1]->getSize());
    }
}
