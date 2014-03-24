<?php
namespace LinguaLeo\ExpertSender;

use LinguaLeo\ExpertSender\Entities\Column;
use LinguaLeo\ExpertSender\Entities\Property;
use LinguaLeo\ExpertSender\Entities\Receiver;
use LinguaLeo\ExpertSender\Entities\Snippet;
use LinguaLeo\ExpertSender\Entities\Where;

class ExpertSenderTest extends \PHPUnit_Framework_TestCase
{
    
    /** @var ExpertSender */
    protected $expertSender;
    
    public function setUp()
    {
        parent::setUp();
        $params = $this->getParams();
        $this->expertSender = new ExpertSender($params['url'], $params['key'], new HttpTransport());
    }

    public function getParams()
    {
        return json_decode(file_get_contents(__DIR__ . '/params.json'), 1);
    }

    public function getTestListId()
    {
        return $this->getParams()['testList'];
    }

    public function getTestTrigger()
    {
        return $this->getParams()['testTrigger'];
    }

    public function getTestTransactional()
    {
        return $this->getParams()['testTransactional'];
    }

    public function getTestEmailPattern()
    {
        return $this->getParams()['testGmailEmailPattern'];
    }

    public function getTestTableName()
    {
        return $this->getParams()['testTableName'];
    }

    public function testLists()
    {
        $randomEmail = sprintf("some_random_%s@gmail.com", rand(0, 100000000000) . rand(0, 1000000000000));

        $listId = $this->getTestListId();
        $result = $this->expertSender->addUserToList(
            $randomEmail,
            $listId,
            [new Property(1775, ExpertSenderEnum::TYPE_STRING, 'female')],
            'Alex'
        );

        $this->assertTrue($result->isOk());
        $this->assertEquals(0, $result->getErrorCode());
        $this->assertEquals('', $result->getErrorMessage());

        $result = $this->expertSender->deleteUser($randomEmail);
        $this->assertTrue($result->isOk());

        $result = $this->expertSender->deleteUser($randomEmail);
        $this->assertFalse($result->isOk());
        $this->assertEquals(404, $result->getErrorCode());
        $this->assertRegExp('~not found~', $result->getErrorMessage());
    }

    public function testAddTableRow()
    {
        $result = $this->expertSender->addTableRow($this->getTestTableName(), [
            new Column('name', 'Alex'),
            new Column('age', 22),
            new Column('sex', 1),
            new Column('created_at', date(DATE_W3C))
        ]);
        $this->assertTrue($result->isOk());
    }

    /**
     * @depends testAddTableRow
     */
    public function testGetTableData()
    {
        $result = $this->expertSender->getTableData(
            $this->getTestTableName(),
            [new Column('name'), new Column('sex')],
            [new Where('age', ExpertSenderEnum::OPERATOR_EQUALS, 22)]
        );
        $this->assertTrue($result->isOk());
        $tableData = $result->getData();
        $this->assertEquals(['Alex', 'True'], $tableData[0]);
    }

    /**
     * @depends testAddTableRow
     */
    public function testUpdateTableRow()
    {
        $result = $this->expertSender->updateTableRow($this->getTestTableName(), [
            new Column('name', 'Alex'),
            new Column('age', 22),
        ], [
            new Column('sex', 0),
            new Column('created_at', date(DATE_W3C, strtotime('-1 week')))
        ]);
        $this->assertTrue($result->isOk());
    }

    /**
     * @depends testUpdateTableRow
     */
    public function testDeleteTableRow()
    {
        $result = $this->expertSender->deleteTableRow($this->getTestTableName(), [
            new Column('name', 'Alex'),
            new Column('age', 22)
        ]);
        $this->assertTrue($result->isOk());
    }
    
    public function testChangeEmail()
    {
        $randomEmail = sprintf("some_random_%s@gmail.com", rand(0, 100000000000) . rand(0, 1000000000000));
        $randomEmail2 = sprintf("some_random_%s@gmail.com", rand(0, 100000000000) . rand(0, 1000000000000));

        $listId = $this->getTestListId();

        $this->expertSender->addUserToList(
            $randomEmail,
            $listId,
            [new Property(1775, ExpertSenderEnum::TYPE_STRING, 'female')],
            'Alex'
        );

        $result = $this->expertSender->getUserId($randomEmail);
        $oldId = $result->getId();
        $this->assertTrue(is_numeric($oldId));

        $this->expertSender->changeEmail($listId, $randomEmail, $randomEmail2);
        $result = $this->expertSender->getUserId($randomEmail2);
        $this->assertEquals($result->getId(), $oldId);

        try {
            $this->expertSender->getUserId($randomEmail);
            $exceptionThrown = false;
        } catch (\Exception $e) {
            $exceptionThrown = true;
        }
        $this->assertTrue($exceptionThrown);
    }

    public function testSendTrigger()
    {
        $randomEmail = sprintf($this->getTestEmailPattern(), rand(0, 100000000000) . rand(0, 1000000000000));
        $listId = $this->getTestListId();
        $this->expertSender->addUserToList($randomEmail, $listId, [new Property(1775, ExpertSenderEnum::TYPE_STRING, 'male')], 'Vladimir');
        $this->expertSender->sendTrigger($this->getTestTrigger(), [new Receiver($randomEmail)]);
        $this->assertTrue(true);
    }

    public function testSendTransactional()
    {
        $randomEmail = sprintf($this->getTestEmailPattern(), rand(0, 100000000000) . rand(0, 1000000000000));
        $listId = $this->getTestListId();
        $this->expertSender->addUserToList($randomEmail, $listId, [new Property(1775, ExpertSenderEnum::TYPE_STRING, 'male')], 'Vladimir');
        $this->expertSender->sendTransactional($this->getTestTransactional(), new Receiver($randomEmail), [new Snippet('code', 123456)]);
        $this->assertTrue(true);
    }

}