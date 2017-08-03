<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Model\SubscribersGetResponse;

/**
 * Event from subscriber's events history
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class Event
{
    /**
     * @var \DateTime Start date
     */
    private $startDate;

    /**
     * @var \DateTime End date
     */
    private $endDate;

    /**
     * Type of message involved in an event
     *
     * Newsletter, Autoresponder, Trigger, Transactional etc
     *
     * @var string
     */
    private $messageType;

    /**
     * Type of event
     *
     * Send, Open, Click, Bounce, Complaint, Confirm, Unsubscribe
     *
     * @var string
     */
    private $eventType;

    /**
     * @var int Number of event occurrences between StartDate and EndDate
     */
    private $eventCount;

    /**
     * @var int ID of message involved in an event
     */
    private $messageId;

    /**
     * @var string Subject of message involved in an event
     */
    private $messageSubject;

    /**
     * Constructor.
     *
     * @param \DateTime $startDate Start date
     * @param \DateTime $endDate End date
     * @param string $messageType Type of message involved in an event
     * @param string $eventType Type of event
     * @param int $eventCount Number of event occurrences between StartDate and EndDate
     * @param int $messageId ID of message involved in an event
     * @param string $messageSubject Subject of message involved in an event
     */
    public function __construct(
        \DateTime $startDate,
        \DateTime $endDate,
        string $messageType,
        string $eventType,
        int $eventCount,
        int $messageId,
        string $messageSubject
    ) {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->messageType = $messageType;
        $this->eventType = $eventType;
        $this->eventCount = $eventCount;
        $this->messageId = $messageId;
        $this->messageSubject = $messageSubject;
    }

    /**
     * Get start date
     *
     * @return \DateTime Start date
     */
    public function getStartDate(): \DateTime
    {
        return $this->startDate;
    }

    /**
     * Get end date
     *
     * @return \DateTime End date
     */
    public function getEndDate(): \DateTime
    {
        return $this->endDate;
    }

    /**
     * Get type of message involved in an event
     *
     * @return string Type of message involved in an event
     */
    public function getMessageType(): string
    {
        return $this->messageType;
    }

    /**
     * Get type of event
     *
     * @return string Type of event
     */
    public function getEventType(): string
    {
        return $this->eventType;
    }

    /**
     * Get number of event occurrences between StartDate and EndDate
     *
     * @return int Number of event occurrences between StartDate and EndDate
     */
    public function getEventCount(): int
    {
        return $this->eventCount;
    }

    /**
     * Get ID of message involved in an event
     *
     * @return int ID of message involved in an event
     */
    public function getMessageId(): int
    {
        return $this->messageId;
    }

    /**
     * Get subject of message involved in an event
     *
     * @return string Subject of message involved in an event
     */
    public function getMessageSubject(): string
    {
        return $this->messageSubject;
    }
}
