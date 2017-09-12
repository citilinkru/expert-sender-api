<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Resource;

use Citilink\ExpertSenderApi\AbstractResource;
use Citilink\ExpertSenderApi\Enum\ActivitiesGetRequest\ActivityType;
use Citilink\ExpertSenderApi\Enum\ActivitiesGetRequest\ReturnColumnsSet;
use Citilink\ExpertSenderApi\Request\ActivitiesGetRequest;
use Citilink\ExpertSenderApi\Response\ActivitiesGetResponse\BouncesActivityGetResponse;
use Citilink\ExpertSenderApi\Response\ActivitiesGetResponse\ClicksActivityGetResponse;
use Citilink\ExpertSenderApi\Response\ActivitiesGetResponse\ComplaintsActivityGetResponse;
use Citilink\ExpertSenderApi\Response\ActivitiesGetResponse\ConfirmationsActivityGetResponse;
use Citilink\ExpertSenderApi\Response\ActivitiesGetResponse\GoalsActivityGetResponse;
use Citilink\ExpertSenderApi\Response\ActivitiesGetResponse\OpensActivityGetResponse;
use Citilink\ExpertSenderApi\Response\ActivitiesGetResponse\RemovalsActivityGetResponse;
use Citilink\ExpertSenderApi\Response\ActivitiesGetResponse\SendsActivityGetResponse;
use Citilink\ExpertSenderApi\Response\ActivitiesGetResponse\SubscriptionsActivityGetResponse;

/**
 * Subscriber activity resource
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class SubscriberActivityResource extends AbstractResource
{
    /**
     * Get subscriptions activity response.
     *
     * @param \DateTime $date Date
     *
     * @return SubscriptionsActivityGetResponse Response
     */
    public function getSubscriptions(\DateTime $date): SubscriptionsActivityGetResponse
    {
        return new SubscriptionsActivityGetResponse(
            $this->requestSender->send(
                new ActivitiesGetRequest($date, ActivityType::SUBSCRIPTIONS())
            )
        );
    }

    /**
     * Get confirmations activity response
     *
     * @param \DateTime $date Date
     *
     * @return ConfirmationsActivityGetResponse Response
     */
    public function getConfirmations(\DateTime $date): ConfirmationsActivityGetResponse
    {
        return new ConfirmationsActivityGetResponse(
            $this->requestSender->send(
                new ActivitiesGetRequest($date, ActivityType::CONFIRMATIONS())
            )
        );
    }

    /**
     * Get sends activity.
     *
     * @param \DateTime $date Date
     * @param ReturnColumnsSet $columnSet Column set to return ({@see ReturnColumnsSet::STANDARD} by default)
     * @param bool $returnGuid Additional column with sent message GUID will be returned.
     *
     * @return SendsActivityGetResponse Response
     */
    public function getSends(
        \DateTime $date,
        ReturnColumnsSet $columnSet = null,
        bool $returnGuid = false
    ): SendsActivityGetResponse {
        return new SendsActivityGetResponse(
            $this->requestSender->send(
                new ActivitiesGetRequest($date, ActivityType::SENDS(), $columnSet, false, $returnGuid)
            )
        );
    }

    /**
     * Get opens activity.
     *
     * @param \DateTime $date Date
     * @param ReturnColumnsSet $columnSet Column set to return ({@see ReturnColumnsSet::STANDARD} by default)
     * @param bool $returnGuid Additional column with sent message GUID will be returned.
     *
     * @return OpensActivityGetResponse Response
     */
    public function getOpens(
        \DateTime $date,
        ReturnColumnsSet $columnSet = null,
        bool $returnGuid = false
    ): OpensActivityGetResponse {
        return new OpensActivityGetResponse(
            $this->requestSender->send(
                new ActivitiesGetRequest($date, ActivityType::OPENS(), $columnSet, false, $returnGuid)
            )
        );
    }

    /**
     * Get clicks activity.
     *
     * @param \DateTime $date Date
     * @param ReturnColumnsSet $columnSet Column set to return ({@see ReturnColumnsSet::STANDARD} by default)
     * @param bool $returnTitle Additional column with link title will be returned.
     * @param bool $returnGuid Additional column with sent message GUID will be returned.
     *
     * @return ClicksActivityGetResponse Response
     */
    public function getClicks(
        \DateTime $date,
        ReturnColumnsSet $columnSet = null,
        bool $returnTitle = false,
        bool $returnGuid = false
    ): ClicksActivityGetResponse {
        return new ClicksActivityGetResponse(
            $this->requestSender->send(
                new ActivitiesGetRequest($date, ActivityType::CLICKS(), $columnSet, $returnTitle, $returnGuid)
            )
        );
    }

    /**
     * Get complaints activity.
     *
     * @param \DateTime $date Date
     * @param ReturnColumnsSet $columnSet Column set to return ({@see ReturnColumnsSet::STANDARD} by default)
     * @param bool $returnGuid Additional column with sent message GUID will be returned.
     *
     * @return ComplaintsActivityGetResponse Response
     */
    public function getComplaints(
        \DateTime $date,
        ReturnColumnsSet $columnSet = null,
        bool $returnGuid = false
    ): ComplaintsActivityGetResponse {
        return new ComplaintsActivityGetResponse(
            $this->requestSender->send(
                new ActivitiesGetRequest($date, ActivityType::COMPLAINTS(), $columnSet, false, $returnGuid)
            )
        );
    }

    /**
     * Get removals activity.
     *
     * @param \DateTime $date Date
     * @param ReturnColumnsSet $columnSet Column set to return ({@see ReturnColumnsSet::STANDARD} by default)
     * @param bool $returnGuid Additional column with sent message GUID will be returned.
     *
     * @return RemovalsActivityGetResponse Response
     */
    public function getRemovals(
        \DateTime $date,
        ReturnColumnsSet $columnSet = null,
        bool $returnGuid = false
    ): RemovalsActivityGetResponse {
        return new RemovalsActivityGetResponse(
            $this->requestSender->send(
                new ActivitiesGetRequest($date, ActivityType::REMOVALS(), $columnSet, false, $returnGuid)
            )
        );
    }

    /**
     * Get bounces activity.
     *
     * @param \DateTime $date Date
     * @param ReturnColumnsSet $columnSet Column set to return ({@see ReturnColumnsSet::STANDARD} by default)
     * @param bool $returnGuid Additional column with sent message GUID will be returned.
     *
     * @return BouncesActivityGetResponse Response
     */
    public function getBounces(
        \DateTime $date,
        ReturnColumnsSet $columnSet = null,
        bool $returnGuid = false
    ): BouncesActivityGetResponse {
        return new BouncesActivityGetResponse(
            $this->requestSender->send(
                new ActivitiesGetRequest($date, ActivityType::BOUNCES(), $columnSet, false, $returnGuid)
            )
        );
    }

    /**
     * Get goals activity.
     *
     * @param \DateTime $date Date
     * @param ReturnColumnsSet $columnSet Column set to return ({@see ReturnColumnsSet::STANDARD} by default)
     * @param bool $returnGuid Additional column with sent message GUID will be returned.
     *
     * @return GoalsActivityGetResponse Response
     */
    public function getGoals(
        \DateTime $date,
        ReturnColumnsSet $columnSet = null,
        bool $returnGuid = false
    ): GoalsActivityGetResponse {
        return new GoalsActivityGetResponse(
            $this->requestSender->send(
                new ActivitiesGetRequest($date, ActivityType::BOUNCES(), $columnSet, false, $returnGuid)
            )
        );
    }
}
