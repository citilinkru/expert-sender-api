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
     * @param bool $returnAdditionalDataOnResponse Additional information will be returned for each added subscriber
     * @param bool $useVerboseErrors Use verbose errors in response
     */
    public function __construct(
        $returnAdditionalDataOnResponse = false,
        $useVerboseErrors = false
    ) {
        $this->returnAdditionalDataOnResponse = $returnAdditionalDataOnResponse;
        $this->useVerboseErrors = $useVerboseErrors;
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
