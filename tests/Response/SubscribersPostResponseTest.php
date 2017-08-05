<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Tests\Response;

use Citilink\ExpertSenderApi\Response;
use Citilink\ExpertSenderApi\Response\SubscribersPostResponse;
use PHPUnit\Framework\Assert;

/**
 * SubscribersPostResponseTest
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class SubscribersPostResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test
     */
    public function testValidResponseParsesCorrectly()
    {
        $xml = '<ApiResponse xmlns:xsd="http://www.w3.org/2001/XMLSchema" '
            . 'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
          <Data>
            <SubscriberData>
              <Email>john.smith@domain2.com</Email>
              <Id>4238647</Id>
              <WasAdded>true</WasAdded>
              <WasIgnored>false</WasIgnored>
            </SubscriberData>
            <SubscriberData>
              <Email>jane.doe@domain2.com</Email>
              <Id>4238648</Id>
              <WasAdded>false</WasAdded>
              <WasIgnored>true</WasIgnored>
            </SubscriberData>
          </Data>
        </ApiResponse>';
        $response = new SubscribersPostResponse(
            new Response(new \GuzzleHttp\Psr7\Response(201, ['Content-Length' => strlen($xml)], $xml))
        );
        Assert::assertTrue($response->isOk());
        $subscriberDataList = $response->getChangedSubscribersData();
        Assert::assertCount(2, $subscriberDataList);

        Assert::assertEquals('john.smith@domain2.com', $subscriberDataList[0]->getEmail());
        Assert::assertEquals(4238647, $subscriberDataList[0]->getId());
        Assert::assertEquals(true, $subscriberDataList[0]->isWasAdded());
        Assert::assertEquals(false, $subscriberDataList[0]->isWasIgnored());

        Assert::assertEquals('jane.doe@domain2.com', $subscriberDataList[1]->getEmail());
        Assert::assertEquals(4238648, $subscriberDataList[1]->getId());
        Assert::assertEquals(false, $subscriberDataList[1]->isWasAdded());
        Assert::assertEquals(true, $subscriberDataList[1]->isWasIgnored());
    }
}
