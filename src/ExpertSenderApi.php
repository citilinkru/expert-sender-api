<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi;

use Citilink\ExpertSenderApi\Enum\BouncesGetRequest\BounceType;
use Citilink\ExpertSenderApi\Request\BouncesGetRequest;
use Citilink\ExpertSenderApi\Request\TimeGetRequest;
use Citilink\ExpertSenderApi\Resource\DataTablesResource;
use Citilink\ExpertSenderApi\Resource\MessagesResource;
use Citilink\ExpertSenderApi\Resource\SubscribersResource;
use Citilink\ExpertSenderApi\Response\BouncesGetResponse;
use Citilink\ExpertSenderApi\Response\TimeGetResponse;

/**
 * Expert Sender API
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class ExpertSenderApi
{
    /**
     * @var RequestSenderInterface Request sender
     */
    private $requestSender;

    /**
     * Constructor.
     *
     * @param RequestSenderInterface $requestSender Request sender
     */
    public function __construct(RequestSenderInterface $requestSender)
    {
        $this->requestSender = $requestSender;
    }

    /**
     * Get Subscribers resource
     *
     * @return SubscribersResource Subscribers resource
     */
    public function subscribers(): SubscribersResource
    {
        return new SubscribersResource($this->requestSender);
    }

    /**
     * Get server time response
     *
     * @return TimeGetResponse Server time response
     */
    public function getServerTime(): TimeGetResponse
    {
        return new TimeGetResponse($this->requestSender->send(new TimeGetRequest()));
    }

    /**
     * Get bounces data
     *
     * @param \DateTime $startDate Start date
     * @param \DateTime $endDate End date
     * @param BounceType|null $bounceType Bounce type
     *
     * @return BouncesGetResponse Bounces data
     */
    public function getBouncesList(
        \DateTime $startDate,
        \DateTime $endDate,
        BounceType $bounceType = null
    ): BouncesGetResponse {
        return new BouncesGetResponse(
            $this->requestSender->send(new BouncesGetRequest($startDate, $endDate, $bounceType))
        );
    }

    /**
     * Get data tables resource
     *
     * @return DataTablesResource Data tables resource
     */
    public function dataTables(): DataTablesResource
    {
        return new DataTablesResource($this->requestSender);
    }

    /**
     * Get messages resource
     *
     * @return MessagesResource Messages resource
     */
    public function messages(): MessagesResource
    {
        return new MessagesResource($this->requestSender);
    }
}
