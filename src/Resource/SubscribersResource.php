<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Resource;

use Citilink\ExpertSenderApi\AbstractResource;
use Citilink\ExpertSenderApi\Enum\RemovedSubscribersGetRequest\Option;
use Citilink\ExpertSenderApi\Enum\RemovedSubscribersGetRequest\RemoveType;
use Citilink\ExpertSenderApi\Enum\SubscribersGetRequest\DataOption;
use Citilink\ExpertSenderApi\Model\SubscribersPostRequest\Options;
use Citilink\ExpertSenderApi\Model\SubscribersPostRequest\SubscriberInfo;
use Citilink\ExpertSenderApi\Request\RemovedSubscriberGetRequest;
use Citilink\ExpertSenderApi\Request\SubscribersDeleteRequest;
use Citilink\ExpertSenderApi\Request\SubscribersGetRequest;
use Citilink\ExpertSenderApi\Request\SubscribersPostRequest;
use Citilink\ExpertSenderApi\Response\RemovedSubscribersGetResponse;
use Citilink\ExpertSenderApi\Response\SubscribersGetEventsHistoryResponse;
use Citilink\ExpertSenderApi\Response\SubscribersGetFullResponse;
use Citilink\ExpertSenderApi\Response\SubscribersGetLongResponse;
use Citilink\ExpertSenderApi\Response\SubscribersGetShortResponse;
use Citilink\ExpertSenderApi\Response\SubscribersPostResponse;
use Citilink\ExpertSenderApi\ResponseInterface;

/**
 * Subscribers resource
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class SubscribersResource extends AbstractResource
{
    /**
     * Get short information about subscriber
     *
     * @param string $email Email
     *
     * @return SubscribersGetShortResponse Short information about subscriber
     */
    public function getShort(string $email): SubscribersGetShortResponse
    {
        return new SubscribersGetShortResponse(
            $this->requestSender->send(new SubscribersGetRequest($email, DataOption::SHORT()))
        );
    }

    /**
     * Get long information of subscriber
     *
     * @param string $email Email
     *
     * @return SubscribersGetLongResponse Long information of subscriber
     */
    public function getLong(string $email): SubscribersGetLongResponse
    {
        return new SubscribersGetLongResponse(
            $this->requestSender->send(new SubscribersGetRequest($email, DataOption::LONG()))
        );
    }

    /**
     * Get full info about subscriber
     *
     * @param string $email Email
     *
     * @return SubscribersGetFullResponse Full info about subscriber
     */
    public function getFull(string $email): SubscribersGetFullResponse
    {
        return new SubscribersGetFullResponse(
            $this->requestSender->send(new SubscribersGetRequest($email, DataOption::FULL()))
        );
    }

    /**
     * Get events history of subscriber
     *
     * @param string $email Email
     *
     * @return SubscribersGetEventsHistoryResponse Events history of subscriber
     */
    public function getEventsHistory(string $email): SubscribersGetEventsHistoryResponse
    {
        return new SubscribersGetEventsHistoryResponse(
            $this->requestSender->send(new SubscribersGetRequest($email, DataOption::EVENTS_HISTORY()))
        );
    }

    /**
     * Add or edit subscriber
     *
     * @param SubscriberInfo[] $subscriberInfos Subscribers information list
     * @param Options|null $options Options
     *
     * @return SubscribersPostResponse Response
     */
    public function addOrEdit(array $subscriberInfos, Options $options = null): SubscribersPostResponse
    {
        return new SubscribersPostResponse(
            $this->requestSender->send(new SubscribersPostRequest($subscriberInfos, $options))
        );
    }

    /**
     * Delete subscriber by ID
     *
     * @param int $id Subscriber ID
     * @param int|null $listId List ID
     *
     * @return ResponseInterface Response
     */
    public function deleteById(int $id, int $listId = null): ResponseInterface
    {
        return $this->requestSender->send(SubscribersDeleteRequest::createFromId($id, $listId));
    }

    /**
     * Delete subscriber by email
     *
     * @param string $email Subscriber Email
     * @param int|null $listId List ID
     *
     * @return ResponseInterface Response
     */
    public function deleteByEmail(string $email, int $listId = null): ResponseInterface
    {
        return $this->requestSender->send(SubscribersDeleteRequest::createFromEmail($email, $listId));
    }

    /**
     * Get removed subscribers
     *
     * @param int[] $listIds List IDs. If specified, only removed subscribers from given lists will be returned. If
     *      not specified, removed subscribers from all lists will be returned
     * @param RemoveType[] $removeTypes Remove types (reasons). If specified, only subscribers removed for listed
     *      reasons will be returned. If omitted, all reasons will be included
     * @param \DateTime $startDate End date. If specified, subscribers removed prior to this date will not be returned.
     *      May be used together with endDate to specify a period of time
     * @param \DateTime $endDate Start date. If specified, subscribers removed after this date will not be returned.
     *      May be used together with startDate to specify a period of time
     * @param Option $option Option. If specified, additional subscriber information will be returned
     *
     * @return RemovedSubscribersGetResponse Response with removed subscribers data
     */
    public function getRemovedSubscribers(
        array $listIds = [],
        array $removeTypes = [],
        \DateTime $startDate = null,
        \DateTime $endDate = null,
        Option $option = null
    ): RemovedSubscribersGetResponse {
        $response = $this->requestSender->send(
            new RemovedSubscriberGetRequest($listIds, $removeTypes, $startDate, $endDate, $option)
        );

        return new RemovedSubscribersGetResponse($response);
    }
}
