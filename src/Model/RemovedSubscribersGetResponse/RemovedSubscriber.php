<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Model\RemovedSubscribersGetResponse;

use Citilink\ExpertSenderApi\Model\SubscriberData;

/**
 * Removed subscriber
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class RemovedSubscriber
{
    /**
     * @var string Email
     */
    private $email;

    /**
     * @var int List ID
     */
    private $listId;

    /**
     * @var \DateTime Date of unsubscription
     */
    private $unsubscribedOn;

    /**
     * @var SubscriberData|null Subscriber's data
     */
    private $subscriberData;

    /**
     * RemovedSubscriber constructor.
     *
     * @param string $email Email
     * @param int $listId List ID
     * @param \DateTime $unsubscribedOn Date of unsubscription
     * @param SubscriberData $subscriberData Subscriber's data
     */
    public function __construct($email, $listId, \DateTime $unsubscribedOn, SubscriberData $subscriberData = null)
    {
        $this->email = $email;
        $this->listId = $listId;
        $this->unsubscribedOn = $unsubscribedOn;
        $this->subscriberData = $subscriberData;
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
     * Get list ID
     *
     * @return int List ID
     */
    public function getListId(): int
    {
        return $this->listId;
    }

    /**
     * Get date of unsubscription
     *
     * @return \DateTime Date of unsubscription
     */
    public function getUnsubscribedOn(): \DateTime
    {
        return $this->unsubscribedOn;
    }

    /**
     * Get subscriber's data
     *
     * If you want get subscriber's data, you should set option="Customs" in
     * {@see RemovedSubscribersGetRequest}
     *
     * @return SubscriberData|null Subscriber's data
     */
    public function getSubscriberData(): ?SubscriberData
    {
        return $this->subscriberData;
    }
}