<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Model\SnoozedSubscribersGetResponse;

/**
 * Snoozed subscriber
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class SnoozedSubscriber
{
    /**
     * @var string Email
     */
    private $email;

    /**
     * @var int Identifier of list that subscriber snoozed his subscription from
     */
    private $listId;

    /**
     * @var \DateTime Date and time when subscription suspension expires
     */
    private $snoozedUntil;

    /**
     * Constructor.
     *
     * @param string $email Email
     * @param int $listId Identifier of list that subscriber snoozed his subscription from
     * @param \DateTime $snoozedUntil Date and time when subscription suspension expires
     */
    public function __construct(string $email, int $listId, \DateTime $snoozedUntil)
    {
        $this->email = $email;
        $this->listId = $listId;
        $this->snoozedUntil = $snoozedUntil;
    }

    /**
     * Get email
     *
     * @return string Email
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Get identifier of list that subscriber snoozed his subscription from
     *
     * @return int Identifier of list that subscriber snoozed his subscription from
     */
    public function getListId(): int
    {
        return $this->listId;
    }

    /**
     * Get date and time when subscription suspension expires
     *
     * @return \DateTime Date and time when subscription suspension expires
     */
    public function getSnoozedUntil(): \DateTime
    {
        return $this->snoozedUntil;
    }
}
