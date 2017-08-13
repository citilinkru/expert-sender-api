<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Tests\Request;

use Citilink\ExpertSenderApi\Enum\HttpMethod;
use Citilink\ExpertSenderApi\Model\TriggersPostRequest\Receiver;
use Citilink\ExpertSenderApi\Request\TriggersPostRequest;
use PHPUnit\Framework\Assert;

/**
 * TriggersPostRequestTest
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class TriggersPostRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test
     */
    public function testCommonUsage()
    {
        $request = new TriggersPostRequest(
            24,
            [
                Receiver::createWithEmail('mail@mail.com'),
                Receiver::createWithId(23),
            ]
        );

        $xml = '<Data xsi:type="TriggerReceivers"><Receivers><Receiver><Email>mail@mail.com</Email></Receiver>'
            . '<Receiver><Id>23</Id></Receiver></Receivers></Data>';
        Assert::assertEquals($xml, $request->toXml());
        Assert::assertEquals([], $request->getQueryParams());
        Assert::assertTrue($request->getMethod()->equals(HttpMethod::POST()));
        Assert::assertEquals('/Api/Triggers/24', $request->getUri());
    }
}
