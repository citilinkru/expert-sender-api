<?php
namespace LinguaLeo\ExpertSender;

use LinguaLeo\ExpertSender\Chunks\Property;

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

    public function getTestListId() {
        return $this->getParams()['testList'];
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
}