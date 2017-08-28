<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Model\ActivitiesGetResponse;

/**
 * Goal activity
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class GoalActivity extends AbstractActivity
{
    /**
     * @var int Identifier of sent message
     */
    private $messageId;

    /**
     * @var string Subject of sent message
     */
    private $messageSubject;

    /**
     * @var int|null List ID. Exists only if with extended column set
     */
    private $listId;

    /**
     * @var string|null List name. Exists only if with extended column set
     */
    private $listName;

    /**
     * @var string|null Sent message GUID. Exists only if returnGuid=true in request
     */
    private $messageGuid;

    /**
     * @var int Fulfilled goal value. Can be 0 if goal had no particular value assigned.
     */
    private $goalValue;

    /**
     * Constructor.
     *
     * @param string $email Email
     * @param \DateTime $date Complain date
     * @param int $messageId Identifier of sent message
     * @param string $messageSubject Subject of sent message
     * @param int $goalValue Fulfilled goal value. Can be 0 if goal had no particular value assigned.
     * @param int|null $listId List ID
     * @param string|null $listName List name
     * @param null|string $messageGuid Sent message GUID
     */
    public function __construct(
        $email,
        \DateTime $date,
        int $messageId,
        string $messageSubject,
        int $goalValue,
        ?int $listId,
        ?string $listName,
        ?string $messageGuid
    ) {
        parent::__construct($email, $date);
        $this->messageId = $messageId;
        $this->messageSubject = $messageSubject;
        $this->listId = $listId;
        $this->listName = $listName;
        $this->messageGuid = $messageGuid;
        $this->goalValue = $goalValue;
    }

    /**
     * Get identifier of sent message
     *
     * @return int Identifier of sent message
     */
    public function getMessageId(): int
    {
        return $this->messageId;
    }

    /**
     * Get subject of sent message
     *
     * @return string Subject of sent message
     */
    public function getMessageSubject(): string
    {
        return $this->messageSubject;
    }

    /**
     * Get list ID
     *
     * Exists only if with extended column set in request
     *
     * @return int|null List ID
     */
    public function getListId(): ?int
    {
        return $this->listId;
    }

    /**
     * Get list name
     *
     * Exists only if with extended column set in request
     *
     * @return null|string List name
     */
    public function getListName(): ?string
    {
        return $this->listName;
    }

    /**
     * Get sent message GUID
     *
     * Exists only if returnGuid=true in request
     *
     * @return null|string Sent message GUID
     */
    public function getMessageGuid(): ?string
    {
        return $this->messageGuid;
    }

    /**
     * Get fulfilled goal value. Can be 0 if goal had no particular value assigned.
     *
     * @return int Fulfilled goal value. Can be 0 if goal had no particular value assigned.
     */
    public function getGoalValue(): int
    {
        return $this->goalValue;
    }
}
