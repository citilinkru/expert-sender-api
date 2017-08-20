<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Tests\Response;

use Citilink\ExpertSenderApi\Response;
use Citilink\ExpertSenderApi\Response\DataTablesDeleteRowsPostResponse;
use PHPUnit\Framework\Assert;

/**
 * DataTablesDeleteRowsPostResponseTest
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class DataTablesDeleteRowsPostResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test
     */
    public function testGetCount()
    {
        $xml = '<ApiResponse xmlns:xsd="http://www.w3.org/2001/XMLSchema" '
            .'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"><Count>25</Count></ApiResponse>';
        $response = new DataTablesDeleteRowsPostResponse(
            new Response(
                new \GuzzleHttp\Psr7\Response(
                    200,
                    ['Content-Type' => 'text/xml', 'Content-Length' => strlen($xml)],
                    $xml
                )
            )
        );

        Assert::assertTrue($response->isOk());
        Assert::assertFalse($response->isEmpty());
        Assert::assertEquals(25, $response->getCount());
    }
}
