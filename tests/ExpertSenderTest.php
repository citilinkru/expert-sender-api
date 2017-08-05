<?php

namespace Citilink\ExpertSenderApi\Tests;

use Citilink\ExpertSenderApi\Enum\SubscribersPostRequest\Mode;
use Citilink\ExpertSenderApi\Model\BouncesGetResponse\Bounce;
use Citilink\ExpertSenderApi\Model\SubscribersPostRequest\Identifier;
use Citilink\ExpertSenderApi\Model\TransactionalRequest\Receiver;
use Citilink\ExpertSenderApi\Model\TransactionalRequest\Snippet;
use Citilink\ExpertSenderApi\ExpertSender;
use Citilink\ExpertSenderApi\ExpertSenderApi;
use Citilink\ExpertSenderApi\HttpTransport;
use Citilink\ExpertSenderApi\Model\SubscribersPostRequest\SubscriberInfo;
use Citilink\ExpertSenderApi\RequestSender;
use GuzzleHttp\Client;
use PHPUnit\Framework\Assert;

class ExpertSenderTest extends \PHPUnit_Framework_TestCase
{
    /** @var ExpertSender */
    protected $expertSender;

    /** @var array|null */
    protected $params = null;

    /**
     * @var ExpertSenderApi
     */
    protected $api;

    public function setUp()
    {
        parent::setUp();

        $this->expertSender = new ExpertSender(
            $this->getParam('url'),
            $this->getParam('key'),
            new HttpTransport()
        );

        $this->api = new ExpertSenderApi(
            new RequestSender(new Client(['base_uri' => $this->getParam('url')]), $this->getParam('key'))
        );

    }

    public function getParams()
    {
        $paramsPath = __DIR__ . '/params.json';

        if (!is_file($paramsPath)) {
            $this->markTestSkipped('params.json is required to run this test');
        }

        return json_decode(file_get_contents($paramsPath), 1);
    }

    public function getParam($param)
    {
        if (!$this->params) {
            $this->params = $this->getParams();
            if (!$this->params) {
                $this->params = [];
            }
        }


        if (!isset($this->params[$param]) || null === $this->params[$param]) {
            $this->markTestSkipped($param . ' must be configured in params.json to run this test');
        }

        return $this->params[$param];
    }

    public function getTestListId()
    {
        return $this->getParam('testList');
    }

    public function getTestTrigger()
    {
        return $this->getParam('testTrigger');
    }

    public function getTestTransactional()
    {
        return $this->getParam('testTransactional');
    }

    public function getTestEmailPattern()
    {
        return $this->getParam('testGmailEmailPattern');
    }

    public function getTestTableName()
    {
        return $this->getParam('testTableName');
    }

    public function testLists()
    {
        $randomEmail = sprintf('some_random_%s@gmail.com', rand(0, 100000000000) . rand(0, 1000000000000));
        $trackingCode = 'phpunit'.time();

        $subscriberData = new SubscriberInfo(Identifier::createEmail($randomEmail), $this->getTestListId());
        $subscriberData->setFirstName('Test');
        $subscriberData->setLastName('TestTest');
        $subscriberData->setVendor('phpunit tests');
        $subscriberData->setTrackingCode($trackingCode);

        $addResult = $this->api->subscribers()->addOrEdit([$subscriberData]);

        $deleteResult = $this->api->subscribers()->deleteByEmail($randomEmail);

        $this->assertTrue($addResult->isOk());
        $this->assertSame(null, $addResult->getErrorCode());
        $this->assertEquals([], $addResult->getErrorMessages());

        $this->assertTrue($deleteResult->isOk());

//        $invalidDeleteResult = $this->expertSender->deleteUser($randomEmail);
//        $this->assertFalse($invalidDeleteResult->isOk());
//        $this->assertEquals(404, $invalidDeleteResult->getErrorCode());
//        $this->assertRegExp('~not found~', $invalidDeleteResult->getErrorMessage());
    }

//    /**
//     * @group table
//     */
//    public function testAddTableRow()
//    {
//        $result = $this->expertSender->addTableRow($this->getTestTableName(), [
//            new ColumnChunk('name', 'Alex'),
//            new ColumnChunk('age', 22),
//            new ColumnChunk('sex', 1),
//            new ColumnChunk('created_at', date(DATE_W3C))
//        ]);
//        $this->assertTrue($result->isOk());
//    }
//
//    /**
//     * @group table
//     * @depends testAddTableRow
//     */
//    public function testGetTableData()
//    {
//        $result = $this->expertSender->getTableData(
//            $this->getTestTableName(),
//            [new ColumnChunk('name'), new ColumnChunk('sex')],
//            [new WhereChunk('age', Operator::EQUAL(), 22)]
//        );
//        $this->assertTrue($result->isOk());
//        $tableData = $result->getData();
//        $this->assertEquals(2, count($tableData));
//        $this->assertEquals(['Alex', 'True'], $tableData[1]);
//    }
//
//    /**
//     * @group table
//     * @depends testAddTableRow
//     */
//    public function testUpdateTableRow()
//    {
//        $result = $this->expertSender->updateTableRow($this->getTestTableName(), [
//            new ColumnChunk('name', 'Alex'),
//            new ColumnChunk('age', 22),
//        ], [
//            new ColumnChunk('sex', 0),
//            new ColumnChunk('created_at', date(DATE_W3C, strtotime('-1 week')))
//        ]);
//        $this->assertTrue($result->isOk());
//    }
//
//    /**
//     * @group table
//     * @depends testUpdateTableRow
//     */
//    public function testDeleteTableRow()
//    {
//        $result = $this->expertSender->deleteTableRow($this->getTestTableName(), [
//            new ColumnChunk('name', 'Alex'),
//            new ColumnChunk('age', 22)
//        ]);
//        $this->assertTrue($result->isOk());
//    }

    public function testChangeEmail()
    {
        $randomEmail = sprintf('some_random_%s@gmail.com', rand(0, 100000000000) . rand(0, 1000000000000));
        $randomEmail2 = sprintf('some_random_%s@gmail.com', rand(0, 100000000000) . rand(0, 1000000000000));

        $listId = $this->getTestListId();

        $subscriberData = new SubscriberInfo(Identifier::createEmail($randomEmail), $listId);
        $subscriberData->setName('Test');
        $this->api->subscribers()->addOrEdit([$subscriberData]);

        $subscriberInfo = $this->api->subscribers()->getFull($randomEmail);
        $oldId = $subscriberInfo->getSubscriberData()->getId();
        $this->assertTrue(is_numeric($oldId));

        $subscriberInfoForChangeEmail = new SubscriberInfo(
            Identifier::createId($oldId),
            $listId,
            Mode::IGNORE_AND_UPDATE()
        );
        $subscriberInfoForChangeEmail->setEmail($randomEmail2);
        $this->api->subscribers()->addOrEdit([$subscriberInfoForChangeEmail]);
        $subscriberInfo2 = $this->api->subscribers()->getFull($randomEmail2);
        $this->assertEquals($subscriberInfo2->getSubscriberData()->getId(), $oldId);
        $this->api->subscribers()->deleteByEmail($randomEmail2);

        $subscriberInfoByOldEmail = $this->api->subscribers()->getFull($randomEmail);
        $this->assertFalse($subscriberInfoByOldEmail->isOk());
        $this->assertEquals(400, $subscriberInfoByOldEmail->getHttpStatusCode());
        $this->assertEquals(400, $subscriberInfoByOldEmail->getErrorCode());
    }

    /**
     * Test
     */
    public function testBouncesGet()
    {
        $response = $this->api->bounces()->get(new \DateTime('2016-01-01'), new \DateTime('2016-01-10'));
        Assert::assertTrue($response->isOk());
        Assert::assertFalse($response->isEmpty());
        /** @var Bounce[] $rows */
        $rows = iterator_to_array($response->getBounces());
        Assert::assertGreaterThan(0, count($rows));
    }

//    public function testSendTrigger()
//    {
//        $randomEmail = sprintf($this->getTestEmailPattern(), rand(0, 100000000000) . rand(0, 1000000000000));
//        $listId = $this->getTestListId();
//
//        $subscriberInfo = new SubscriberInfo();
//        $subscriberInfo->setFirstName('Test');
//        $this->api->subscribers()->add($randomEmail, $listId, $subscriberInfo);
//
//        $this->expertSender->sendTrigger($this->getTestTrigger(), [Receiver::createWithEmail($randomEmail)]);
//
//        $this->assertTrue(true);
//    }
//
    public function testSendTransactional()
    {
        $randomEmail = sprintf('some_random_%s@gmail.com', rand(0, 100000000000) . rand(0, 1000000000000));
        $listId = $this->getTestListId();
        $subscriberData = new SubscriberInfo(Identifier::createEmail($randomEmail), $listId);
        $subscriberData->setFirstName('Test');
        $this->api->subscribers()->addOrEdit([$subscriberData]);

        $response = $this->api->transactionals()->send(
            $this->getTestTransactional(),
            Receiver::createWithEmail($randomEmail),
            [new Snippet('code', 123456)],
            [],
            true
        );

        $this->api->subscribers()->deleteByEmail($randomEmail);

        Assert::assertTrue($response->isOk());
        Assert::assertNotEmpty($response->getGuid());
    }
}
