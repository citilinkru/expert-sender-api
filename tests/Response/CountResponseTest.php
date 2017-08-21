<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Tests\Response;

use Citilink\ExpertSenderApi\Response;
use Citilink\ExpertSenderApi\Response\CountResponse;
use PHPUnit\Framework\Assert;

/**
 * CountResponseTest
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class CountResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test
     */
    public function testGetCount()
    {
        $xml = '<ApiResponse xmlns:xsd="http://www.w3.org/2001/XMLSchema" '
            . 'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"><Count>25</Count></ApiResponse>';
        $response = new CountResponse(
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
