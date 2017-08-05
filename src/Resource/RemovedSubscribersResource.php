<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Resource;

use Citilink\ExpertSenderApi\AbstractResource;
use Citilink\ExpertSenderApi\Enum\RemovedSubscribersGetRequest\Option;
use Citilink\ExpertSenderApi\Enum\RemovedSubscribersGetRequest\RemoveType;
use Citilink\ExpertSenderApi\Request\RemovedSubscriberGetRequest;
use Citilink\ExpertSenderApi\Response\RemovedSubscribersGetResponse;

/**
 * RemovedSubscribers resource
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class RemovedSubscribersResource extends AbstractResource
{
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