<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Model\SubscribersRequest;

/**
 * Options of {@see SubscriberPostRequest}
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class Options
{
    /**
     * @var bool Allow add subscriber, that was unsubscribed
     */
    private $allowAddUserThatWasUnsubscribed = true;

    /**
     * @var bool Allow add subscriber, that was deleted
     */
    private $allowAddUserThatWasDeleted = true;

    /**
     * Force sending another confirmation email to subscriber
     *
     * Applies only to Double Opt-In lists and non-confirmed subscribers
     *
     * @var boolean
     */
    private $force = false;

    /**
     * @var bool Additional information will be returned for each added subscriber
     */
    private $returnAdditionalDataOnResponse = false;

    /**
     * @var bool Use verbose errors in response
     */
    private $useVerboseErrors = false;

    /**
     * Constructor.
     *
     * @param bool $allowAddUserThatWasUnsubscribed Allow add subscriber, that was unsubscribed
     * @param bool $allowAddUserThatWasDeleted Allow add subscriber, that was deleted
     * @param bool $force Force sending another confirmation email to subscriber
     * @param bool $returnAdditionalDataOnResponse Additional information will be returned for each added subscriber
     * @param bool $useVerboseErrors Use verbose errors in response
     */
    public function __construct(
        $allowAddUserThatWasUnsubscribed = true,
        $allowAddUserThatWasDeleted = true,
        $force = false,
        $returnAdditionalDataOnResponse = false,
        $useVerboseErrors = false
    ) {
        $this->allowAddUserThatWasUnsubscribed = $allowAddUserThatWasUnsubscribed;
        $this->allowAddUserThatWasDeleted = $allowAddUserThatWasDeleted;
        $this->force = $force;
        $this->returnAdditionalDataOnResponse = $returnAdditionalDataOnResponse;
        $this->useVerboseErrors = $useVerboseErrors;
    }

    /**
     * Allow add subscriber, that was unsubscribe
     *
     * @return bool Allow add subscriber, that was unsubscribe
     */
    public function isAllowAddUserThatWasUnsubscribed(): bool
    {
        return $this->allowAddUserThatWasUnsubscribed;
    }

    /**
     * Allow add subscriber, that was deleted
     *
     * @return bool Allow add subscriber, that was deleted
     */
    public function isAllowAddUserThatWasDeleted(): bool
    {
        return $this->allowAddUserThatWasDeleted;
    }

    /**
     * Force sending another confirmation email to subscriber
     *
     * @return bool Force sending another confirmation email to subscriber
     */
    public function isForce(): bool
    {
        return $this->force;
    }

    /**
     * Additional information will be returned for each added subscriber
     *
     * @return bool Additional information will be returned for each added subscriber
     */
    public function isReturnAdditionalDataOnResponse(): bool
    {
        return $this->returnAdditionalDataOnResponse;
    }

    /**
     * Use verbose errors in response
     *
     * @return bool Use verbose errors in response
     */
    public function isUseVerboseErrors(): bool
    {
        return $this->useVerboseErrors;
    }
}
