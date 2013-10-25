<?php
namespace LinguaLeo\ExpertSender;

use LinguaLeo\ExpertSender\Entities\Property;
use LinguaLeo\ExpertSender\Entities\Receiver;
use LinguaLeo\ExpertSender\Entities\Snippet;

class ExpertSenderTest extends \PHPUnit_Framework_TestCase
{
    public function getParams()
    {
        return json_decode(file_get_contents(__DIR__ . '/params.json'), 1);
    }

    public function getExpertSender()
    {
        $params = $this->getParams();

        return new ExpertSender($params['url'], $params['key'], new HttpTransport());
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

    public function testLists()
    {
        $randomEmail = sprintf("some_random_%s@gmail.com", rand(0, 100000000000) . rand(0, 1000000000000));

        $listId = $this->getTestListId();

        $expertSender = $this->getExpertSender();
        $result = $expertSender->addUserToList($randomEmail, $listId, [new Property(1775, ExpertSenderEnum::TYPE_STRING, 'female')], 'Alex');

        $this->assertTrue($result->isOk());
        $this->assertEquals(0, $result->getErrorCode());
        $this->assertEquals('', $result->getErrorMessage());

        $result = $expertSender->deleteUser($randomEmail);
        $this->assertTrue($result->isOk());

        $result = $expertSender->deleteUser($randomEmail);
        $this->assertFalse($result->isOk());
        $this->assertEquals(404, $result->getErrorCode());
        $this->assertRegExp('~not found~', $result->getErrorMessage());
    }

    public function testChangeEmail()
    {
        $randomEmail = sprintf("some_random_%s@gmail.com", rand(0, 100000000000) . rand(0, 1000000000000));
        $randomEmail2 = sprintf("some_random_%s@gmail.com", rand(0, 100000000000) . rand(0, 1000000000000));

        $listId = $this->getTestListId();

        $expertSender = $this->getExpertSender();
        $expertSender->addUserToList($randomEmail, $listId, [new Property(1775, ExpertSenderEnum::TYPE_STRING, 'female')], 'Alex');

        $result = $expertSender->getUserId($randomEmail);
        $oldId = $result->getId();
        $this->assertTrue(is_numeric($oldId));

        $expertSender->changeEmail($listId, $randomEmail, $randomEmail2);

        $result = $expertSender->getUserId($randomEmail2);

        $this->assertEquals($result->getId(), $oldId);

        try {
            $expertSender->getUserId($randomEmail);
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

        $expertSender = $this->getExpertSender();
        $expertSender->addUserToList($randomEmail, $listId, [new Property(1775, ExpertSenderEnum::TYPE_STRING, 'male')], 'Vladimir');

        $expertSender->sendTrigger($this->getTestTrigger(), [new Receiver($randomEmail)]);

        $this->assertTrue(true);
    }

    public function testSendTransactional()
    {
        $randomEmail = sprintf($this->getTestEmailPattern(), rand(0, 100000000000) . rand(0, 1000000000000));

        $listId = $this->getTestListId();

        $expertSender = $this->getExpertSender();
        $expertSender->addUserToList($randomEmail, $listId, [new Property(1775, ExpertSenderEnum::TYPE_STRING, 'male')], 'Vladimir');

        $expertSender->sendTransactional($this->getTestTransactional(), new Receiver($randomEmail), [new Snippet('code', 123456)]);

        $this->assertTrue(true);
    }
}