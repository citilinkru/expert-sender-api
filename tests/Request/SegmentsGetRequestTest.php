<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Tests\Request;

use Citilink\ExpertSenderApi\Enum\HttpMethod;
use Citilink\ExpertSenderApi\Request\SegmentsGetRequest;

/**
 * SegmentsGetRequestTest
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class SegmentsGetRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test
     */
    public function testToXmlShouldReturnEmptyString()
    {
        $request = new SegmentsGetRequest();

        $this->assertSame('', $request->toXml());
    }

    /**
     * Test
     */
    public function testGetQueryParamsShouldReturnEmptyArray()
    {
        $request = new SegmentsGetRequest();

        $this->assertSame([], $request->getQueryParams());
    }

    /**
     * Test
     */
    public function testGetMethodShouldReturnGetHttpMethod()
    {
        $request = new SegmentsGetRequest();

        $this->assertTrue($request->getMethod()->equals(HttpMethod::GET()));
    }

    /**
     * Test
     */
    public function testGetUriShouldReturnProperUri()
    {
        $request = new SegmentsGetRequest();

        $this->assertSame('/Api/Segments', $request->getUri());
    }
}
