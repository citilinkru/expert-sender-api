<?php

namespace LinguaLeo\ExpertSender\Request;

use LinguaLeo\ExpertSender\Entities\Property;
use LinguaLeo\ExpertSender\ExpertSenderEnum;
use BadMethodCallException;

/**
 * Represents adding subscriber to list request attributes.
 *
 * https://sites.google.com/a/expertsender.com/api-documentation/methods/subscribers/add-subscriber#TOC-Request-data-format
 */
class AddUserToList
{
    /**
     * @var boolean
     */
    private $frozen = false;

    /**
     * @var integer|null
     */
    private $listId = null;

    /**
     * @var integer|null
     */
    private $id = null;

    /**
     * @var string|null
     */
    private $email = null;

    /**
     * @var string|null
     */
    private $firstName = null;

    /**
     * @var string|null
     */
    private $lastName = null;

    /**
     * @var string|null
     */
    private $name = null;

    /**
     * @var string|null
     */
    private $ip = null;

    /**
     * @var string|null
     */
    private $trackingCode = null;

    /**
     * @var string|null
     */
    private $vendor = null;

    /**
     * @var boolean
     */
    private $force = false;

    /**
     * @var string
     */
    private $mode = ExpertSenderEnum::MODE_ADD_AND_UPDATE;

    /**
     * @var array
     */
    private $properties = [];

    /**
     * @return boolean
     */
    public function isValid()
    {
        return null !== $this->email && null !== $this->listId;
    }

    /**
     * @return boolean
     */
    public function isFrozen()
    {
        return $this->frozen;
    }

    /**
     * @return AddUserToList
     * @throws BadMethodCallException
     */
    public function freeze()
    {
        if (!$this->isValid()) {
            throw new BadMethodCallException('AddUserToListRequest cannot be frozen when is invalid.');
        }

        $this->frozen = true;

        return $this;
    }

    /**
     * @param integer|null $listId
     * @return AddUserToList
     * @throws BadMethodCallException
     */
    public function setListId($listId = null)
    {
        $this->exceptionIfFrozen();

        $this->listId = null === $listId ? null : (int) $listId;

        return $this;
    }

    /**
     * @return integer|null
     */
    public function getListId()
    {
        return $this->listId;
    }

    /**
     * @param integer|null $id
     * @return AddUserToList
     * @throws BadMethodCallException
     */
    public function setId($id = null)
    {
        $this->exceptionIfFrozen();

        $this->id = null === $id ? null : (int) $id;

        return $this;
    }

    /**
     * @return integer|null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string|null $email
     * @return AddUserToList
     * @throws BadMethodCallException
     */
    public function setEmail($email = null)
    {
        $this->exceptionIfFrozen();

        $this->email = $email;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string|null $firstName
     * @return AddUserToList
     * @throws BadMethodCallException
     */
    public function setFirstName($firstName = null)
    {
        $this->exceptionIfFrozen();

        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string|null $lastName
     * @return AddUserToList
     * @throws BadMethodCallException
     */
    public function setLastName($lastName = null)
    {
        $this->exceptionIfFrozen();

        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string|null $name
     * @return AddUserToList
     * @throws BadMethodCallException
     */
    public function setName($name = null)
    {
        $this->exceptionIfFrozen();

        $this->name = $name;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string|null $ip
     * @return AddUserToList
     * @throws BadMethodCallException
     */
    public function setIp($ip = null)
    {
        $this->exceptionIfFrozen();

        $this->ip = $ip;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param string|null $trackingCode
     * @return AddUserToList
     * @throws BadMethodCallException
     * @throws \InvalidArgumentException
     */
    public function setTrackingCode($trackingCode = null)
    {
        $this->exceptionIfFrozen();

        if (strlen($trackingCode) > 20) {
            throw new \InvalidArgumentException('Tracking code is too long, max is 20 characters');
        }

        $this->trackingCode = $trackingCode;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getTrackingCode()
    {
        return $this->trackingCode;
    }

    /**
     * @param string|null $vendor
     * @return AddUserToList
     * @throws BadMethodCallException
     */
    public function setVendor($vendor = null)
    {
        $this->exceptionIfFrozen();

        $this->vendor = $vendor;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getVendor()
    {
        return $this->vendor;
    }

    /**
     * @param boolean $force
     * @return AddUserToList
     * @throws BadMethodCallException
     * @throws InvalidArgumentException
     */
    public function setForce($force)
    {
        $this->exceptionIfFrozen();

        if (!is_bool($force)) {
            throw new \InvalidArgumentException();
        }

        $this->force = $force;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getForce()
    {
        return $this->force;
    }

    /**
     * @param string $mode
     * @return AddUserToList
     * @throws BadMethodCallException
     * @throws \InvalidArgumentException
     */
    public function setMode($mode)
    {
        $this->exceptionIfFrozen();

        if (!in_array($mode, ExpertSenderEnum::getModes())) {
            throw new \InvalidArgumentException('Invalid mode: '.$mode);
        }

        $this->mode = $mode;

        return $this;
    }

    /**
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @param Property $property
     * @return AddUserToList
     * @throws BadMethodCallException
     */
    public function addProperty(Property $property)
    {
        $this->exceptionIfFrozen();

        $this->properties[] = $property;

        return $this;
    }

    /**
     * @param array $properties
     * @return AddUserToList
     * @throws BadMethodCallException
     */
    public function setProperties(array $properties)
    {
        $this->exceptionIfFrozen();

        $this->properties = [];

        foreach ($properties as $property) {
            $this->addProperty($property);
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @throws BadMethodCallException
     */
    private function exceptionIfFrozen()
    {
        if ($this->frozen) {
            throw new BadMethodCallException('Attributes cannot be set when AddUserToListRequest is frozen.');
        }
    }
}
