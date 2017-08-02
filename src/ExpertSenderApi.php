<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi;

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
     * Return Subscribers resource
     *
     * @return SubscribersResource Subscribers resource
     */
    public function subscribers(): SubscribersResource
    {
        return new SubscribersResource($this->requestSender);
    }

    /**
     * Return Transaction resource
     *
     * @return TransactionalsResource Transaction resource
     */
    public function transactionals(): TransactionalsResource
    {
        return new TransactionalsResource($this->requestSender);
    }

    /**
     * Return Time resource
     *
     * @return TimeResource Time resource
     */
    public function time(): TimeResource
    {
        return new TimeResource($this->requestSender);
    }
}
