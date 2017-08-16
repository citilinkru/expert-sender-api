<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Tests\Response;

use Citilink\ExpertSenderApi\Enum\DataType;
use Citilink\ExpertSenderApi\Enum\SubscriberPropertySource;
use Citilink\ExpertSenderApi\Enum\SubscribersResponse\SubscriberPropertyType;
use Citilink\ExpertSenderApi\Model\RemovedSubscribersGetResponse\RemovedSubscriber;
use Citilink\ExpertSenderApi\Model\SubscriberData;
use Citilink\ExpertSenderApi\Model\SubscribersGetResponse\SubscriberProperty;
use Citilink\ExpertSenderApi\Response;
use Citilink\ExpertSenderApi\Response\RemovedSubscribersGetResponse;
use PHPUnit\Framework\Assert;

/**
 * RemovedSubscribersGetResponseTest
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class RemovedSubscribersGetResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test
     */
    public function testGetRemovedSubscriberWithoutCustoms()
    {
        $xml = '<ApiResponse xmlns:xsd="http://www.w3.org/2001/XMLSchema" '
            . 'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
           <Data>
             <RemovedSubscribers>
               <RemovedSubscriber>
                 <Email>test123@yahoo.com</Email>
                 <ListId>1</ListId>
                 <UnsubscribedOn>2011-07-21T00:00:00Z</UnsubscribedOn>
               </RemovedSubscriber>
               <RemovedSubscriber>
                 <Email>test456@yahoo.com</Email>
                 <ListId>1</ListId>
                 <UnsubscribedOn>2011-09-14T11:37:20Z</UnsubscribedOn>
               </RemovedSubscriber>
              </RemovedSubscribers>
           </Data>
         </ApiResponse>';

        $response = new RemovedSubscribersGetResponse(
            new Response(
                new \GuzzleHttp\Psr7\Response(
                    200,
                    ['Content-Type' => 'text/xml', 'Content-Length' => strlen($xml)],
                    $xml
                )
            )
        );

        Assert::assertTrue($response->isOk());
        Assert::assertEquals(200, $response->getHttpStatusCode());
        Assert::assertFalse($response->isEmpty());
        Assert::assertNull($response->getErrorCode());
        Assert::assertEmpty($response->getErrorMessages());

        /** @var RemovedSubscriber[] $removedSubscribers */
        $removedSubscribers = \iter\toArray($response->getRemovedSubscribers());
        Assert::assertCount(2, $removedSubscribers);
        Assert::assertNull($removedSubscribers[0]->getSubscriberData());
        Assert::assertEquals('test123@yahoo.com', $removedSubscribers[0]->getEmail());
        Assert::assertEquals(1, $removedSubscribers[0]->getListId());
        Assert::assertEquals('2011-07-21 00:00:00', $removedSubscribers[0]->getUnsubscribedOn()->format('Y-m-d H:i:s'));

        Assert::assertNull($removedSubscribers[1]->getSubscriberData());
        Assert::assertEquals('test456@yahoo.com', $removedSubscribers[1]->getEmail());
        Assert::assertEquals(1, $removedSubscribers[1]->getListId());
        Assert::assertEquals('2011-09-14 11:37:20', $removedSubscribers[1]->getUnsubscribedOn()->format('Y-m-d H:i:s'));
    }

    /**
     * Test
     */
    public function testGetRemovedSubscribersWithCustomsOption()
    {
        $xml = '<ApiResponse xmlns:xsd="http://www.w3.org/2001/XMLSchema" '
            . 'xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
          <Data>
            <RemovedSubscribers>
              <RemovedSubscriber xsi:type="FullRemovedSubscriber">
                <Email>grzegorz.tylak@expertsender.com</Email>
                <ListId>1194</ListId>
                <UnsubscribedOn>2016-06-21T08:33:34Z</UnsubscribedOn>
                <Properties>
                  <Property>
                    <Id>1</Id>
                    <Source>NotSet</Source>
                    <StringValue xsi:type="xsd:string">abc</StringValue>
                    <Type>Text</Type>
                    <FriendlyName>tekst</FriendlyName>
                    <Description>tekstowa cecha xxx</Description>
                    <Name>tekst</Name>
                    <DefaultStringValue xsi:type="xsd:string">abc</DefaultStringValue>
                  </Property>
                  <Property>
                    <Id>9</Id>
                    <Source>NotSet</Source>
                    <IntValue xsi:type="xsd:int">1</IntValue>
                    <Type>Boolean</Type>
                    <FriendlyName>testowy boolean "fifi"</FriendlyName>
                    <Description>to jest test</Description>
                    <Name>test_bool</Name>
                    <DefaultIntValue xsi:type="xsd:int">1</DefaultIntValue>
                  </Property>
                  <Property>
                    <Id>23</Id>
                    <Source>NotSet</Source>
                    <DecimalValue xsi:type="xsd:decimal">3.14</DecimalValue>
                    <Type>Money</Type>
                    <FriendlyName>kwota</FriendlyName>
                    <Description />
                    <Name>kwota</Name>
                    <DefaultDecimalValue xsi:type="xsd:decimal">3.14</DefaultDecimalValue>
                  </Property>
                </Properties>
                <Id>4238630</Id>
                <Firstname>Firstname</Firstname>
                <Lastname>Lastname</Lastname>
                <Ip>127.0.0.1</Ip>
                <Vendor>vendor</Vendor>
              </RemovedSubscriber>
            </RemovedSubscribers>
          </Data>
        </ApiResponse>';

        $response = new RemovedSubscribersGetResponse(
            new Response(
                new \GuzzleHttp\Psr7\Response(
                    200,
                    ['Content-Type' => 'text/xml', 'Content-Length' => strlen($xml)],
                    $xml
                )
            )
        );

        Assert::assertTrue($response->isOk());
        Assert::assertEquals(200, $response->getHttpStatusCode());
        Assert::assertFalse($response->isEmpty());
        Assert::assertNull($response->getErrorCode());
        Assert::assertEmpty($response->getErrorMessages());

        /** @var RemovedSubscriber[] $removedSubscribers */
        $removedSubscribers = \iter\toArray($response->getRemovedSubscribers());

        Assert::assertCount(1, $removedSubscribers);


        Assert::assertEquals('grzegorz.tylak@expertsender.com', $removedSubscribers[0]->getEmail());
        Assert::assertEquals(1194, $removedSubscribers[0]->getListId());
        Assert::assertEquals('2016-06-21 08:33:34', $removedSubscribers[0]->getUnsubscribedOn()->format('Y-m-d H:i:s'));

        // need type conversion for phpstan valid check, because we check on null without !== null, but with method
        // assertNotNull
        /** @var SubscriberData $subscriberData */
        $subscriberData = $removedSubscribers[0]->getSubscriberData();
        Assert::assertNotNull($subscriberData);
        Assert::assertEquals(4238630, $subscriberData->getId());
        Assert::assertEquals('Firstname', $subscriberData->getFirstname());
        Assert::assertEquals('Lastname', $subscriberData->getLastname());
        Assert::assertEquals('127.0.0.1', $subscriberData->getIp());
        Assert::assertEquals('vendor', $subscriberData->getVendor());

        /** @var SubscriberProperty[] $properties */
        $properties = \iter\toArray($subscriberData->getProperties());
        Assert::assertEquals(1, $properties[0]->getId());
        Assert::assertTrue($properties[0]->getSource()->equals(SubscriberPropertySource::NOT_SET()));
        Assert::assertTrue($properties[0]->getValue()->getType()->equals(DataType::STRING()));
        Assert::assertEquals('abc', $properties[0]->getValue()->getStringValue());
        Assert::assertEquals('abc', $properties[0]->getValue()->getDefaultStringValue());
        Assert::assertTrue($properties[0]->getType()->equals(SubscriberPropertyType::TEXT()));
        Assert::assertEquals('tekst', $properties[0]->getFriendlyName());
        Assert::assertEquals('tekstowa cecha xxx', $properties[0]->getDescription());
        Assert::assertEquals('tekst', $properties[0]->getName());
    }
}
