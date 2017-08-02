<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Model\SubscribersResponse;

use Citilink\ExpertSenderApi\Enum\SubscribersResponse\StateOnListStatus;

/**
 * Subscriber's state on list
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class StateOnList
{
    /**
     * @var int List ID
     */
    private $listId;

    /**
     * @var string List name
     */
    private $name;

    /**
     * @var StateOnListStatus Status
     */
    private $status;

    /**
     * @var \DateTime Subscription date
     */
    private $subscriptionDate;

    /**
     * Constructor
     *
     * @param int $listId List ID
     * @param string $name List name
     * @param StateOnListStatus $status Status
     * @param \DateTime $subscriptionDate Subscription date
     */
    public function __construct(int $listId, string $name, StateOnListStatus $status, \DateTime $subscriptionDate)
    {
        $this->listId = $listId;
        $this->name = $name;
        $this->status = $status;
        $this->subscriptionDate = $subscriptionDate;
    }

    /**
     * Return list ID
     *
     * @return int List ID
     */
    public function getListId(): int
    {
        return $this->listId;
    }

    /**
     * Return list name
     *
     * @return string List name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Return status
     *
     * @return StateOnListStatus Status
     */
    public function getStatus(): StateOnListStatus
    {
        return $this->status;
    }

    /**
     * Return subscription date
     *
     * @return \DateTime Subscription date
     */
    public function getSubscriptionDate(): \DateTime
    {
        return $this->subscriptionDate;
    }
}
