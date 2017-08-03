<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Tests\Request;

use Citilink\ExpertSenderApi\Enum\HttpMethod;
use Citilink\ExpertSenderApi\Model\SubscribersPostRequest\Identifier;
use Citilink\ExpertSenderApi\Model\SubscribersPostRequest\Property;
use Citilink\ExpertSenderApi\Model\SubscribersPostRequest\Value;
use Citilink\ExpertSenderApi\Enum\SubscribersPostRequest\Mode;
use Citilink\ExpertSenderApi\Model\SubscribersPostRequest\Options;
use Citilink\ExpertSenderApi\Model\SubscribersPostRequest\SubscriberInfo;
use Citilink\ExpertSenderApi\Request\SubscribersPostRequest;
use PHPUnit\Framework\Assert;

class SubscribersPostRequestTest extends \PHPUnit_Framework_TestCase
{
    /**
     * Test
     */
    public function testAddSubscriberRequestGenerateValidXml()
    {
        $subscriberData = new SubscriberInfo(
            Identifier::createEmail('mail@mail.ru'),
            25,
            Mode::ADD_AND_UPDATE()
        );
        $subscriberData->setFirstName('firstname');
        $subscriberData->setName('firstname lastname');
        $subscriberData->setLastName('lastname');
        $subscriberData->setTrackingCode('tracking code');
        $subscriberData->setVendor('vendor');
        $subscriberData->setIp('127.0.0.1');
        $subscriberData->setForce(true);
        $subscriberData->setCustomSubscriberId('custom-subscriber-id');
        $subscriberData->setAllowAddUserThatWasDeleted(false);
        $subscriberData->setAllowAddUserThatWasUnsubscribed(false);
        $subscriberData->addPropertyChunk(new Property(1, Value::createInt(24)));
        $subscriberData->addPropertyChunk(new Property(2, Value::createString('string')));
        $subscriberData->addPropertyChunk(new Property(3, Value::createBoolean(true)));
        $subscriberData->addPropertyChunk(new Property(16, Value::createBoolean(false)));
        $subscriberData->addPropertyChunk(new Property(15, Value::createDouble(23.4)));
        $subscriberData->addPropertyChunk(
            new Property(4, Value::createDateFromDateTime(new \DateTime('2000-01-01 12:00:00')))
        );
        $subscriberData->addPropertyChunk(
            new Property(5, Value::createDateTimeFromDateTime(new \DateTime('2000-01-01 12:00:00')))
        );

        $request = new SubscribersPostRequest(
            [$subscriberData],
            new Options(true, true)
        );

        $expectedXml = '<MultiData><Subscriber><Mode>AddAndUpdate</Mode><ListId>25</ListId><MatchingMode>Email'
            . '</MatchingMode><Email>mail@mail.ru</Email><Force>true</Force>'
            . '<AllowUnsubscribed>false</AllowUnsubscribed><AllowRemoved>false</AllowRemoved>'
            . '<CustomSubscriberId>custom-subscriber-id</CustomSubscriberId><FirstName>firstname'
            . '</FirstName><LastName>lastname</LastName><Name>firstname lastname</Name><Ip>127.0.0.1</Ip>'
            . '<TrackingCode>tracking code</TrackingCode><Vendor>vendor</Vendor><Properties><Property><Id>1</Id>'
            . '<Value xsi:type="xs:int">24</Value></Property><Property><Id>2</Id><Value xsi:type="xs:string">'
            . 'string</Value></Property><Property><Id>3</Id><Value xsi:type="xs:boolean">true</Value></Property>'
            . '<Property><Id>16</Id><Value xsi:type="xs:boolean">false</Value></Property><Property><Id>15</Id>'
            . '<Value xsi:type="xs:double">23.4</Value></Property><Property><Id>4</Id><Value xsi:type="xs:date">'
            . '2000-01-01</Value></Property><Property><Id>5</Id><Value xsi:type="xs:dateTime">2000-01-01T12:00:00'
            . '</Value></Property></Properties></Subscriber></MultiData><VerboseErrors>true'
            . '</VerboseErrors><ReturnData>true</ReturnData>';

        Assert::assertEquals($expectedXml, $request->toXml());
    }

    /**
     * Test
     */
    public function testEditSubscriberWithEmailRequestGenerateValidXml()
    {
        $subscriberData = new SubscriberInfo(
            Identifier::createEmail('mail@mail.ru'),
            25,
            Mode::IGNORE_AND_UPDATE()
        );
        $request = new SubscribersPostRequest([$subscriberData]);

        $expectedXml = '<MultiData><Subscriber><Mode>IgnoreAndUpdate</Mode><ListId>25</ListId>'
            . '<MatchingMode>Email</MatchingMode><Email>mail@mail.ru'
            . '</Email></Subscriber></MultiData>';

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
        $subscriberData = new SubscriberInfo(Identifier::createEmailMd5('md5'), 25);
        $request = new SubscribersPostRequest([$subscriberData]);

        $expectedXml = '<MultiData><Subscriber><Mode>AddAndUpdate</Mode><ListId>25</ListId>'
            . '<MatchingMode>Email</MatchingMode><EmailMd5>md5'
            . '</EmailMd5></Subscriber></MultiData>';

        Assert::assertEquals($expectedXml, $request->toXml());
    }

    /**
     * Test
     */
    public function testChangeEmailRequestGenerateValidXml()
    {
        $subscriberData = new SubscriberInfo(Identifier::createId(12), 25, Mode::IGNORE_AND_UPDATE());
        $subscriberData->setEmail('mail@mail.com');
        $request = new SubscribersPostRequest([$subscriberData]);

        $expectedXml = '<MultiData><Subscriber><Mode>IgnoreAndUpdate</Mode><ListId>25</ListId>'
            . '<MatchingMode>Id</MatchingMode><Id>12</Id>'
            . '<Email>mail@mail.com</Email></Subscriber></MultiData>';

        Assert::assertEquals($expectedXml, $request->toXml());
    }

    /**
     * Test
     */
    public function testAddMultipleSubscribers()
    {
        $infos = [
            new SubscriberInfo(Identifier::createEmail('mail1@mail.ru'), 25, Mode::ADD_AND_IGNORE()),
            new SubscriberInfo(Identifier::createEmailMd5('md5'), 26, Mode::IGNORE_AND_REPLACE()),
        ];

        $request = new SubscribersPostRequest($infos);
        Assert::assertEquals(
            '<MultiData><Subscriber><Mode>AddAndIgnore</Mode><ListId>25</ListId>'
            . '<MatchingMode>Email</MatchingMode><Email>mail1@mail.ru</Email>'
            . '</Subscriber><Subscriber><Mode>IgnoreAndReplace</Mode><ListId>26</ListId>'
            . '<MatchingMode>Email</MatchingMode><EmailMd5>md5</EmailMd5>'
            . '</Subscriber></MultiData>',
            $request->toXml()
        );
    }

}
