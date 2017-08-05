<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Model\SubscribersPostRequest;

use Citilink\ExpertSenderApi\Enum\SubscribersPostRequest\Mode;

/**
 * Subscriber data for add/edit subscriber request
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class SubscriberInfo
{
    /**
     * @var int List ID
     */
    private $listId;

    /**
     * @var string|null Email
     */
    private $email;

    /**
     * @var string|null Custom subscriber ID
     */
    private $customSubscriberId;

    /**
     * @var Mode Adding mode
     */
    private $mode;

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
     * @var bool Allow add subscriber, that was unsubscribed
     */
    private $allowAddUserThatWasUnsubscribed = true;

    /**
     * @var bool Allow add subscriber, that was deleted
     */
    private $allowAddUserThatWasDeleted = true;

    /**
     * Force sending another confirmation email to subscriber
     *
     * Applies only to Double Opt-In lists and non-confirmed subscribers
     *
     * @var bool
     */
    private $force = false;

    /**
     * @var Identifier Identifier of subscriber
     */
    private $identifier;

    /**
     * @var string|null Phone
     */
    private $phone;

    /**
     * Constructor
     *
     * @param Identifier $identifier Identifier of subscriber
     * @param int $listId List ID
     * @param Mode $mode Adding mode (AddAndUpdate by default)
     */
    public function __construct(Identifier $identifier, int $listId, Mode $mode = null)
    {
        $this->identifier = $identifier;
        $this->listId = $listId;
        $this->mode = $mode ?: Mode::ADD_AND_UPDATE();
    }

    /**
     * Get firstname
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
     * Get lastname
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
     * Get full name ("Firstname Lastname")
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
     * Get IP
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
     * Get identifier of source of subscriber (e.g. particular webform on a webpage)
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
     * Get identifier/name of traffic vendor the subscriber came from
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
     * Get subscriber's properties
     *
     * @return Property[] Subscriber's properties
     */
    public function getProperties(): array
    {
        return $this->propertyChunks;
    }

    /**
     * Set allow add subscriber, that was unsubscribed
     *
     * @param bool $allowAddUserThatWasUnsubscribed Allow add subscriber, that was unsubscribed
     */
    public function setAllowAddUserThatWasUnsubscribed(bool $allowAddUserThatWasUnsubscribed): void
    {
        $this->allowAddUserThatWasUnsubscribed = $allowAddUserThatWasUnsubscribed;
    }

    /**
     * Set allow add subscriber, that was deleted
     *
     * @param bool $allowAddUserThatWasDeleted Allow add subscriber, that was deleted
     */
    public function setAllowAddUserThatWasDeleted(bool $allowAddUserThatWasDeleted): void
    {
        $this->allowAddUserThatWasDeleted = $allowAddUserThatWasDeleted;
    }

    /**
     * Set force sending another confirmation email to subscriber
     *
     * @param bool $force Force sending another confirmation email to subscriber
     */
    public function setForce(bool $force): void
    {
        $this->force = $force;
    }

    /**
     * Allow add subscriber, that was unsubscribe
     *
     * @return bool Allow add subscriber, that was unsubscribe
     */
    public function isAllowAddUserThatWasUnsubscribed(): bool
    {
        return $this->allowAddUserThatWasUnsubscribed;
    }

    /**
     * Allow add subscriber, that was deleted
     *
     * @return bool Allow add subscriber, that was deleted
     */
    public function isAllowAddUserThatWasDeleted(): bool
    {
        return $this->allowAddUserThatWasDeleted;
    }

    /**
     * Force sending another confirmation email to subscriber
     *
     * @return bool Force sending another confirmation email to subscriber
     */
    public function isForce(): bool
    {
        return $this->force;
    }

    /**
     * Get list ID
     *
     * @return int List ID
     */
    public function getListId(): int
    {
        return $this->listId;
    }

    /**
     * Get email
     *
     * @return null|string Email
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get adding mode
     *
     * @return Mode Adding mode
     */
    public function getMode(): Mode
    {
        return $this->mode;
    }

    /**
     * Get custom subscriber ID
     *
     * @return string Custom subscriber ID
     */
    public function getCustomSubscriberId(): ?string
    {
        return $this->customSubscriberId;
    }

    /**
     * Set custom subscriber ID
     *
     * @param string $customSubscriberId Custom subscriber ID
     */
    public function setCustomSubscriberId(string $customSubscriberId): void
    {
        $this->customSubscriberId = $customSubscriberId;
    }

    /**
     * Get identifier of subscriber
     *
     * @return Identifier Identifier of subscriber
     */
    public function getIdentifier(): Identifier
    {
        return $this->identifier;
    }

    /**
     * Get phone
     *
     * @return string Phone
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * Set phone
     *
     * @param string $phone Phone
     */
    public function setPhone(string $phone): void
    {
        $this->phone = $phone;
    }

    /**
     * Set email
     *
     * @param string $email Email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
}
