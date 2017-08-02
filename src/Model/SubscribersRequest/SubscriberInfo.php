<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Model\SubscribersRequest;

use Citilink\ExpertSenderApi\Model\SubscribersRequest\Property;

/**
 * Subscriber data for add/edit subscriber request
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class SubscriberInfo
{
    /**
     * @var string|null Firstname
     */
    private $firstName;

    /**
     * @var string|null Lastname
     */
    private $lastName;

    /**
     * @var string|null Full name ("Firstname Lastname")
     */
    private $name;

    /**
     * @var string|null IP
     */
    private $ip;

    /**
     * @var string|null Identifier of source of subscriber (e.g. particular webform on a webpage)
     */
    private $trackingCode;

    /**
     * @var string|null Identifier/name of traffic vendor the subscriber came from
     */
    private $vendor;

    /**
     * @var Property[] Collection of custom subscriber properties
     */
    private $propertyChunks = [];

    /**
     * Return firstname
     *
     * @return null|string Firstname
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * Set firstname
     *
     * @param string $firstName Firstname
     */
    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    /**
     * Return lastname
     *
     * @return null|string Lastname
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * Set lastname
     *
     * @param string $lastName Lastname
     */
    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * Return full name ("Firstname Lastname")
     *
     * @return null|string Full name ("Firstname Lastname")
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Set full name ("Firstname Lastname")
     *
     * @param string $name Full name ("Firstname Lastname")
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Return IP
     *
     * @return null|string IP
     */
    public function getIp(): ?string
    {
        return $this->ip;
    }

    /**
     * Set IP
     *
     * @param string $ip IP
     */
    public function setIp(string $ip): void
    {
        $this->ip = $ip;
    }

    /**
     * Return identifier of source of subscriber (e.g. particular webform on a webpage)
     *
     * @return null|string Identifier of source of subscriber (e.g. particular webform on a webpage)
     */
    public function getTrackingCode(): ?string
    {
        return $this->trackingCode;
    }

    /**
     * Set identifier of source of subscriber (e.g. particular webform on a webpage)
     *
     * @param string $trackingCode Identifier of source of subscriber (e.g. particular webform on a webpage)
     */
    public function setTrackingCode(string $trackingCode): void
    {
        if (strlen($trackingCode) > 20) {
            throw new \InvalidArgumentException('Tracking code is too long, max is 20 characters');
        }

        $this->trackingCode = $trackingCode;
    }

    /**
     * Return identifier/name of traffic vendor the subscriber came from
     *
     * @return null|string Identifier/name of traffic vendor the subscriber came from
     */
    public function getVendor(): ?string
    {
        return $this->vendor;
    }

    /**
     * Set identifier/name of traffic vendor the subscriber came from
     *
     * @param string $vendor Identifier/name of traffic vendor the subscriber came from
     */
    public function setVendor(string $vendor): void
    {
        $this->vendor = $vendor;
    }

    /**
     * Add subscriber's property
     *
     * @param Property $propertyChunk Subscriber's property
     */
    public function addPropertyChunk(Property $propertyChunk): void
    {
        $this->propertyChunks[] = $propertyChunk;
    }

    /**
     * Return subscriber's properties
     *
     * @return Property[] Subscriber's properties
     */
    public function getProperties(): array
    {
        return $this->propertyChunks;
    }
}
