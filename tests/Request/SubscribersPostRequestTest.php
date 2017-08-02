<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Tests\Request;

use Citilink\ExpertSenderApi\Enum\HttpMethod;
use Citilink\ExpertSenderApi\Model\SubscribersRequest\Property;
use Citilink\ExpertSenderApi\Model\SubscribersRequest\Value;
use Citilink\ExpertSenderApi\Enum\SubscribersRequest\Mode;
use Citilink\ExpertSenderApi\Model\SubscribersRequest\Options;
use Citilink\ExpertSenderApi\Model\SubscribersRequest\SubscriberInfo;
use Citilink\ExpertSenderApi\Request\SubscribersPostRequest;
use PHPUnit\Framework\Assert;

class SubscribersPostRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test
     */
    public function testAddSubscriberRequestGenerateValidXml()
    {
        $subscriberData1 = new SubscriberInfo();
        $subscriberData1->setFirstName('firstname');
        $subscriberData1->setName('firstname lastname');
        $subscriberData1->setLastName('lastname');
        $subscriberData1->setTrackingCode('tracking code');
        $subscriberData1->setVendor('vendor');
        $subscriberData1->setIp('127.0.0.1');
        $subscriberData1->addPropertyChunk(new Property(1, Value::createInt(24)));
        $subscriberData1->addPropertyChunk(new Property(2, Value::createString('string')));
        $subscriberData1->addPropertyChunk(new Property(3, Value::createBoolean(true)));
        $subscriberData1->addPropertyChunk(new Property(16, Value::createBoolean(false)));
        $subscriberData1->addPropertyChunk(new Property(15, Value::createDouble(23.4)));
        $subscriberData1->addPropertyChunk(
            new Property(4, Value::createDateFromDateTime(new \DateTime('2000-01-01 12:00:00')))
        );
        $subscriberData1->addPropertyChunk(
            new Property(5, Value::createDateTimeFromDateTime(new \DateTime('2000-01-01 12:00:00')))
        );

        $request = SubscribersPostRequest::createAddSubscriber(
            'mail@mail.ru',
            25,
            $subscriberData1,
            Mode::ADD_AND_UPDATE(),
            new Options(
                false,
                false,
                true,
                true,
                true
            )
        );

        $expectedXml = '<Data xsi:type="Subscriber"><Mode>AddAndUpdate</Mode><ListId>25</ListId><Force>true</Force>'
            . '<AllowUnsubscribed>false</AllowUnsubscribed><AllowRemoved>false</AllowRemoved><Email>mail@mail.ru</Email>'
            . '<FirstName>firstname'
            . '</FirstName><LastName>lastname</LastName><Name>firstname lastname</Name><Ip>127.0.0.1</Ip>'
            . '<TrackingCode>tracking code</TrackingCode><Vendor>vendor</Vendor><Properties><Property><Id>1</Id>'
            . '<Value xsi:type="xs:int">24</Value></Property><Property><Id>2</Id><Value xsi:type="xs:string">'
            . 'string</Value></Property><Property><Id>3</Id><Value xsi:type="xs:boolean">true</Value></Property>'
            . '<Property><Id>16</Id><Value xsi:type="xs:boolean">false</Value></Property><Property><Id>15</Id>'
            . '<Value xsi:type="xs:double">23.4</Value></Property><Property><Id>4</Id><Value xsi:type="xs:date">'
            . '2000-01-01</Value></Property><Property><Id>5</Id><Value xsi:type="xs:dateTime">2000-01-01T12:00:00'
            . '</Value></Property></Properties></Data><VerboseErrors>true'
            . '</VerboseErrors><ReturnData>true</ReturnData>';

        Assert::assertEquals($expectedXml, $request->toXml());
    }

    /**
     * Test
     */
    public function testEditSubscriberWithEmailRequestGenerateValidXml()
    {
        $subscriberData1 = new SubscriberInfo();
        $request = SubscribersPostRequest::createEditSubscriberWithEmail(
            'mail@mail.ru',
            25,
            $subscriberData1,
            Mode::IGNORE_AND_UPDATE()
        );

        $expectedXml = '<Data xsi:type="Subscriber"><Mode>IgnoreAndUpdate</Mode><ListId>25</ListId><Email>mail@mail.ru'
            . '</Email></Data>';

        Assert::assertEquals($expectedXml, $request->toXml());
        Assert::assertTrue($request->getMethod()->equals(HttpMethod::POST()));
        Assert::assertEquals([], $request->getQueryParams());
        Assert::assertEquals('/Api/Subscribers', $request->getUri());
    }

    /**
     * Test
     */
    public function testEditSubscriberWithEmailMd5RequestGenerateValidXml()
    {
        $subscriberData1 = new SubscriberInfo();
        $request = SubscribersPostRequest::createEditSubscriberWithEmailMd5(
            'md5',
            25,
            $subscriberData1
        );

        $expectedXml = '<Data xsi:type="Subscriber"><Mode>AddAndUpdate</Mode><ListId>25</ListId><EmailMd5>md5'
            . '</EmailMd5></Data>';

        Assert::assertEquals($expectedXml, $request->toXml());
    }

    /**
     * Test
     */
    public function testChangeEmailRequestGenerateValidXml()
    {
        $request = SubscribersPostRequest::createChangeEmail(
            12,
            'mail@mail.com',
            25
        );

        $expectedXml = '<Data xsi:type="Subscriber"><Mode>IgnoreAndUpdate</Mode><ListId>25</ListId><Id>12</Id>'
            . '<Email>mail@mail.com</Email></Data>';

        Assert::assertEquals($expectedXml, $request->toXml());
    }

}
