<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Tests\Request;

use Citilink\ExpertSenderApi\Enum\HttpMethod;
use Citilink\ExpertSenderApi\Request\SnoozedSubscribersPostRequest;

/**
 * SnoozedSubscribersPostRequestTest
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class SnoozedSubscribersPostRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test
     */
    public function testCreateWithId()
    {
        $id = 567;
        $snoozedWeeks = 23;
        $listId = 27;
        $request = SnoozedSubscribersPostRequest::createWithId($id, $snoozedWeeks, $listId);

        $this->assertSame([], $request->getQueryParams());
        $this->assertSame('/v2/Api/SnoozedSubscribers', $request->getUri());
        $this->assertSame('<Id>567</Id><ListId>27</ListId><SnoozeWeeks>23</SnoozeWeeks>', $request->toXml());
        $this->assertTrue($request->getMethod()->equals(HttpMethod::POST()));
    }

    /**
     * Test
     */
    public function testCreateWithEmail()
    {
        $email = 'test@test.ru';
        $snoozedWeeks = 23;
        $listId = 27;
        $request = SnoozedSubscribersPostRequest::createWithEmail($email, $snoozedWeeks, $listId);

        $this->assertSame([], $request->getQueryParams());
        $this->assertSame('/v2/Api/SnoozedSubscribers', $request->getUri());
        $this->assertSame('<Email>test@test.ru</Email><ListId>27</ListId><SnoozeWeeks>23</SnoozeWeeks>', $request->toXml());
        $this->assertTrue($request->getMethod()->equals(HttpMethod::POST()));
    }

    /**
     * Test
     */
    public function testXmlShouldNotContainListIdIfItValusIsNull()
    {
        $request = SnoozedSubscribersPostRequest::createWithId(567, 23);

        $this->assertSame('<Id>567</Id><SnoozeWeeks>23</SnoozeWeeks>', $request->toXml());
    }

    /**
     * Test
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Expected a value greater than or equal to 1. Got: 0
     */
    public function testConstructorShouldThrowExceptionIfSnoozeWeeksLessThanOne()
    {
        SnoozedSubscribersPostRequest::createWithId(567, 0);
    }

    /**
     * Test
     *
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Expected a value less than or equal to 26. Got: 27
     */
    public function testConstructorShouldThrowExceptionIfSnoozeWeeksGreaterThan26()
    {
        SnoozedSubscribersPostRequest::createWithId(567, 27);
    }
}
