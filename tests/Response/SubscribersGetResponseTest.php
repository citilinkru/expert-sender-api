<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Tests\Response;

use Citilink\ExpertSenderApi\Enum\SubscribersResponse\StateOnListStatus;
use Citilink\ExpertSenderApi\Enum\SubscribersResponse\Source;
use Citilink\ExpertSenderApi\Enum\SubscribersResponse\Type;
use Citilink\ExpertSenderApi\Enum\DataType;
use Citilink\ExpertSenderApi\Response;
use Citilink\ExpertSenderApi\Response\SubscribersGetFullResponse;
use PHPUnit\Framework\Assert;

/**
 * SubscribersGetResponseTest
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class SubscribersGetResponseTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test
     */
    public function testRealResponseParse()
    {
        $xml = file_get_contents(__DIR__ . '/subscribers_get_full_response.xml');

        $response = new SubscribersGetFullResponse(new Response(
            new \GuzzleHttp\Psr7\Response(200, [], $xml)
        ));
        Assert::assertFalse($response->isInBlackList());
        $stateOnLists = $response->getStateOnLists();
        Assert::assertCount(4, $stateOnLists);
        foreach ($stateOnLists as $stateOnList) {
            switch ($stateOnList->getListId()) {
                case 15:
                    Assert::assertEquals('Registration Регистрация', $stateOnList->getName());
                    Assert::assertTrue(StateOnListStatus::ACTIVE()->equals($stateOnList->getStatus()));
                    Assert::assertEquals(
                        '2014-11-12T11:27:05',
                        $stateOnList->getSubscriptionDate()->format('Y-m-d\TH:i:s')
                    );
                    break;
                case 143:
                    Assert::assertEquals('НЕ_Купил_БТ', $stateOnList->getName());
                    Assert::assertTrue(StateOnListStatus::SNOOZED()->equals($stateOnList->getStatus()));
                    Assert::assertEquals(
                        '2015-11-03T19:31:22',
                        $stateOnList->getSubscriptionDate()->format('Y-m-d\TH:i:s')
                    );
                    break;
                case 153:
                    Assert::assertEquals('В2В_СС', $stateOnList->getName());
                    Assert::assertTrue(StateOnListStatus::UNSUBSCRIBED()->equals($stateOnList->getStatus()));
                    Assert::assertEquals(
                        '2015-11-24T10:32:50',
                        $stateOnList->getSubscriptionDate()->format('Y-m-d\TH:i:s')
                    );
                    break;
                case 157:
                    Assert::assertEquals('Корпоративные клиенты', $stateOnList->getName());
                    Assert::assertTrue(StateOnListStatus::NOT_CONFIRMED()->equals($stateOnList->getStatus()));
                    Assert::assertEquals(
                        '2015-11-27T13:41:06',
                        $stateOnList->getSubscriptionDate()->format('Y-m-d\TH:i:s')
                    );

                    break;
            }
        }

        $stopLists = $response->getSuppressionStopLists();
        Assert::assertCount(2, $stopLists);
        Assert::assertEquals([1 => 'Тестовый стоп-лист 1', 2 => 'Тестовый стоп-лист 2'], $stopLists);

        $properties = $response->getProperties();
        Assert::assertCount(5, $properties);

        Assert::assertEquals(1208798, $response->getId());
        Assert::assertEquals('FIRSTNAME', $response->getFirstname());
        Assert::assertEquals('ID905079', $response->getLastname());
        Assert::assertEquals('есть', $response->getVendor());
        Assert::assertEquals('92.242.35.180', $response->getIp());

        foreach ($properties as $property) {
            switch ($property->getId()) {
                case 2:
                    Assert::assertTrue($property->getSource()->equals(Source::IMPORT()));
                    Assert::assertTrue($property->getValue()->getType()->equals(DataType::STRING()));
                    Assert::assertTrue($property->getType()->equals(Type::TEXT()));
                    Assert::assertEquals('russia_cl', $property->getValue()->getStringValue());
                    Assert::assertEquals('', $property->getValue()->getDefaultStringValue());
                    Assert::assertEquals('Город', $property->getFriendlyName());
                    Assert::assertEquals('city', $property->getName());
                    Assert::assertEquals('Описание', $property->getDescription());
                    break;
                case 3:
                    Assert::assertTrue($property->getSource()->equals(Source::PANEL()));
                    Assert::assertTrue($property->getValue()->getType()->equals(DataType::INTEGER()));
                    Assert::assertTrue($property->getType()->equals(Type::NUMBER()));
                    Assert::assertEquals(1, $property->getValue()->getIntValue());
                    Assert::assertEquals(2, $property->getValue()->getDefaultIntValue());
                    break;
                case 7:
                    Assert::assertTrue($property->getSource()->equals(Source::WEB()));
                    Assert::assertTrue($property->getValue()->getType()->equals(DataType::DATETIME()));
                    Assert::assertTrue($property->getType()->equals(Type::DATETIME()));
                    Assert::assertEquals(
                        '2017-05-16 11:11:11',
                        $property->getValue()->getDatetimeValue()->format('Y-m-d H:i:s')
                    );
                    Assert::assertEquals(
                        '2000-05-16 11:11:11',
                        $property->getValue()->getDefaultDatetimeValue()->format('Y-m-d H:i:s')
                    );
                    break;
                case 12:
                    Assert::assertTrue($property->getSource()->equals(Source::PREF_CENTER()));
                    Assert::assertTrue($property->getType()->equals(Type::MONEY()));
                    Assert::assertTrue($property->getValue()->getType()->equals(DataType::DECIMAL()));
                    Assert::assertEquals(
                        12.3,
                        $property->getValue()->getDecimalValue()
                    );
                    Assert::assertEquals(
                        14.5,
                        $property->getValue()->getDefaultDecimalValue()
                    );
                    break;
            }
        }
    }

    /**
     * @expectedException \UnexpectedValueException
     */
    public function testThrowExceptionIfTypeOfDataIsUnknown()
    {
        $xml = '<ApiResponse xmlns:xsd="http://www.w3.org/2001/XMLSchema"
             xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"><Data><Properties>
            <Property>
                <Id>2</Id>
                <Source>Import</Source>
                <StringValue xsi:type="xsd:string">russia_cl</StringValue>
                <DataType>Unknown</DataType>
                <FriendlyName>Город</FriendlyName>
                <Description>Описание</Description>
                <Name>city</Name>
                <DefaultStringValue xsi:type="xsd:string"></DefaultStringValue>
            </Property></Properties></Data></ApiResponse>';
        $response = new SubscribersGetFullResponse(new Response(
            new \GuzzleHttp\Psr7\Response(200, [], $xml)
        ));
        $response->getProperties();
    }
}
