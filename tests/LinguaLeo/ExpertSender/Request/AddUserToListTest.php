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
        $this->assertEquals(null, $this->request->getName());
        $this->assertEquals(null, $this->request->getIp());
        $this->assertEquals(null, $this->request->getTrackingCode());
        $this->assertEquals(null, $this->request->getVendor());
        $this->assertEquals(false, $this->request->getForce());
        $this->assertEquals('AddAndUpdate', $this->request->getMode());
        $this->assertEquals([], $this->request->getProperties());
    }

    /**
     * @dataProvider provideMethodsValues
     */
    public function testValuesAreSet($field, $value)
    {
        $setter = 'set'.ucfirst($field);
        $getter = 'get'.ucfirst($field);

        $this->request->$setter($value);

        $this->assertSame($value, $this->request->$getter());
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
    public function testCannotBeChangedWhenFrozen($field, $value)
    {
        // minimal setup
        $this->request->setListId(1);
        $this->request->setEmail('test@example.com');

        $this->request->freeze();

        $setter = 'set'.ucfirst($field);

        $this->request->$setter($value);
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
            ['listId', null],
            ['listId', 2],

            ['id', null],
            ['id', 2],

            ['email', null],
            ['email', 'test2@example.com'],

            ['firstName', null],
            ['firstName', 'first_name'],

            ['lastName', null],
            ['lastName', 'last_name'],

            ['name', null],
            ['name', 'Some_Name'],

            ['ip', null],
            ['ip', '10.20.30.40'],

            ['trackingCode', null],
            ['trackingCode', 'tracking_code'],

            ['vendor', null],
            ['vendor', 'my_vendor'],

            ['force', true],
            ['force', false],

            ['mode', ExpertSenderEnum::MODE_ADD_AND_IGNORE],
            ['mode', ExpertSenderEnum::MODE_IGNORE_AND_UPDATE],

            ['properties', []],
            ['properties', [new Property(1, 1, 1)]],
            ['properties', [new Property(2, 2, 2), new Property(3, 3, 3)]],
        ];
    }

    protected function setUp()
    {
        $this->request = new AddUserToList();
    }
}
