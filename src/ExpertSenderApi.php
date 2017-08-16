<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi;

use Citilink\ExpertSenderApi\Enum\BouncesGetRequest\BounceType;
use Citilink\ExpertSenderApi\Request\BouncesGetRequest;
use Citilink\ExpertSenderApi\Request\TimeGetRequest;
use Citilink\ExpertSenderApi\Resource\BouncesResource;
use Citilink\ExpertSenderApi\Resource\DataTablesResource;
use Citilink\ExpertSenderApi\Resource\MessagesResource;
use Citilink\ExpertSenderApi\Resource\RemovedSubscribersResource;
use Citilink\ExpertSenderApi\Resource\SubscribersResource;
use Citilink\ExpertSenderApi\Resource\TimeResource;
use Citilink\ExpertSenderApi\Resource\TransactionalsResource;
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
     * Get Transaction resource
     *
     * @deprecated use {@see ExpertSenderApi::messages} instead
     *
     * @return TransactionalsResource Transaction resource
     */
    public function transactionals(): TransactionalsResource
    {
        return new TransactionalsResource($this->requestSender);
    }

    /**
     * Get Time resource
     *
     * @deprecated use {@see ExpertSenderApi::getServerTime} instead
     *
     * @return TimeResource Time resource
     */
    public function time(): TimeResource
    {
        return new TimeResource($this->requestSender);
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
     * Get Bounces resource
     *
     * @deprecated use {@see ExpertSenderApi::getBouncesList} instead
     *
     * @return BouncesResource Bounces resource
     */
    public function bounces(): BouncesResource
    {
        return new BouncesResource($this->requestSender);
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
     * Get RemovedSubscribers resource
     *
     * @deprecated use {@see ExpertSenderApi::subscribers} instead
     *
     * @return RemovedSubscribersResource RemovedSubscribers resource
     */
    public function removedSubscribers(): RemovedSubscribersResource
    {
        return new RemovedSubscribersResource($this->requestSender);
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
