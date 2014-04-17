<?php

namespace LinguaLeo\ExpertSender\Request;

use LinguaLeo\ExpertSender\Entities\Property;
use LinguaLeo\ExpertSender\ExpertSenderEnum;

class AddUserToListTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var AddUserToList
     */
    private $request;

    public function testDefaultValues()
    {
        $this->assertFalse($this->request->isValid());
        $this->assertFalse($this->request->isFrozen());

        $this->assertEquals(null, $this->request->getListId());
        $this->assertEquals(null, $this->request->getId());
        $this->assertEquals(null, $this->request->getEmail());
        $this->assertEquals(null, $this->request->getFirstName());
        $this->assertEquals(null, $this->request->getLastName());
        $this->assertEquals(null, $this->request->getIp());
        $this->assertEquals('AddAndUpdate', $this->request->getMode());
        $this->assertEquals([], $this->request->getProperties());
    }

    /**
     * @expectedException \BadMethodCallException
     */
    public function testCannotBeFrozenWhenInvalid()
    {
        $this->request->freeze();
    }

    public function testIsValidWithMinimalSetup()
    {
        $this->request->setListId(1);
        $this->request->setEmail('test@test.com');

        $this->assertTrue($this->request->isValid());

        // should not throw exception
        $this->request->freeze();
    }

    /**
     * @depends testIsValidWithMinimalSetup
     * @dataProvider provideMethodsValues
     * @expectedException \BadMethodCallException
     */
    public function testCannotBeChangedWhenFrozen($method, $value)
    {
        // minimal setup
        $this->request->setListId(1);
        $this->request->setEmail('test@example.com');

        $this->request->freeze();

        $this->request->$method($value);
    }

    public function testResetProperties()
    {
        $this->request->setProperties([]);
        $this->assertEquals([], $this->request->getProperties());

        $this->request->addProperty(new Property('', '', ''));
        $this->request->setProperties([]);
        $this->assertEquals([], $this->request->getProperties());
    }

    public function testAddProperty()
    {
        $properties = [
            new Property(1, 1, 1),
            new Property(2, 2, 2),
            new Property(3, 3, 3),
        ];

        $this->request->addProperty($properties[0]);
        $this->request->addProperty($properties[1]);
        $this->request->addProperty($properties[2]);

        $this->assertSame($properties, $this->request->getProperties());
    }

    public function testSetProperties()
    {
        $properties = [
            new Property(1, 1, 1),
            new Property(2, 2, 2),
            new Property(3, 3, 3),
        ];

        $this->request->setProperties($properties);

        $this->assertSame($properties, $this->request->getProperties());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidModeCannotBeSet()
    {
        $this->request->setMode('invalid_mode');
    }

    public function testValidModesCanBeSet()
    {
        foreach (ExpertSenderEnum::getModes() as $mode) {
            $this->request->setMode($mode);

            $this->assertEquals($mode, $this->request->getMode());
        }
    }

    /**
     * @return array
     */
    public function provideMethodsValues()
    {
        return [
            ['setListId', null],
            ['setListId', 2],

            ['setId', null],
            ['setId', 2],

            ['setEmail', null],
            ['setEmail', 'test2@example.com'],

            ['setFirstName', null],
            ['setFirstName', 'first_name'],

            ['setLastName', null],
            ['setLastName', 'last_name'],

            ['setIp', null],
            ['setIp', '10.20.30.40'],

            ['setMode', null],
            ['setMode', 'new_mode'],

            ['setProperties', []],
        ];
    }

    protected function setUp()
    {
        $this->request = new AddUserToList();
    }
}
