<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi;

use Citilink\ExpertSenderApi\Resource\BouncesResource;
use Citilink\ExpertSenderApi\Resource\DataTablesResource;
use Citilink\ExpertSenderApi\Resource\MessagesResource;
use Citilink\ExpertSenderApi\Resource\RemovedSubscribersResource;
use Citilink\ExpertSenderApi\Resource\SubscribersResource;
use Citilink\ExpertSenderApi\Resource\TimeResource;
use Citilink\ExpertSenderApi\Resource\TransactionalsResource;

/**
 * Expert Sender API
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class ExpertSenderApi
{
    /**
     * @var RequestSender Request sender
     */
    private $requestSender;

    /**
     * Constructor.
     *
     * @param RequestSender $requestSender Request sender
     */
    public function __construct(RequestSender $requestSender)
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
     * @return TransactionalsResource Transaction resource
     */
    public function transactionals(): TransactionalsResource
    {
        return new TransactionalsResource($this->requestSender);
    }

    /**
     * Get Time resource
     *
     * @return TimeResource Time resource
     */
    public function time(): TimeResource
    {
        return new TimeResource($this->requestSender);
    }

    /**
     * Get Bounces resource
     *
     * @return BouncesResource Bounces resource
     */
    public function bounces(): BouncesResource
    {
        return new BouncesResource($this->requestSender);
    }

    /**
     * Get RemovedSubscribers resource
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
