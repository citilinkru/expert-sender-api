<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Request;

use Citilink\ExpertSenderApi\Enum\HttpMethod;
use Citilink\ExpertSenderApi\Enum\RemovedSubscribersGetRequest\Option;
use Citilink\ExpertSenderApi\Enum\RemovedSubscribersGetRequest\RemoveType;
use Citilink\ExpertSenderApi\RequestInterface;
use Webmozart\Assert\Assert;

/**
 * Request for GET RemoveSubscribers
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class RemovedSubscriberGetRequest implements RequestInterface
{
    /**
     * List IDs
     *
     * If specified, only removed subscribers from given lists will be returned. If not specified, removed subscribers
     * from all lists will be returned
     *
     * @var int[]
     */
    private $listIds = [];

    /**
     * Remove types (reasons)
     *
     * If specified, only subscribers removed for listed reasons will be returned. If omitted, all reasons
     * will be included
     *
     * @var RemoveType[]
     */
    private $removeTypes = [];

    /**
     * Start date
     *
     * If specified, subscribers removed prior to this date will not be returned. May be used together with endDate
     * to specify a period of time
     *
     * @var \DateTime
     */
    private $startDate;

    /**
     * End date
     *
     * If specified, subscribers removed after this date will not be returned. May be used together with startDate
     * to specify a period of time
     *
     * @var \DateTime
     */
    private $endDate;

    /**
     * Option
     *
     * If specified, additional subscriber information will be returned
     *
     * @var Option
     */
    private $option;

    /**
     * Constructor
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
     */
    public function __construct(
        array $listIds = [],
        array $removeTypes = [],
        \DateTime $startDate = null,
        \DateTime $endDate = null,
        Option $option = null
    ) {
        Assert::allInteger($listIds);
        Assert::allIsInstanceOf($removeTypes, RemoveType::class);
        $this->listIds = $listIds;
        $this->removeTypes = $removeTypes;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->option = $option;
    }

    /**
     * @inheritdoc
     */
    public function toXml(): string
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function getQueryParams(): array
    {
        $params = [];
        if (!empty($this->listIds)) {
            $params['listIds'] = implode(',', $this->listIds);
        }

        if (!empty($this->removeTypes)) {
            $params['removeTypes'] = implode(',', $this->removeTypes);
        }

        if ($this->startDate !== null) {
            $params['startDate'] = $this->startDate->format('Y-m-d');
        }

        if ($this->endDate !== null) {
            $params['endDate'] = $this->endDate->format('Y-m-d');
        }

        if ($this->option !== null) {
            $params['option'] = $this->option->getValue();
        }

        return $params;
    }

    /**
     * @inheritdoc
     */
    public function getMethod(): HttpMethod
    {
        return HttpMethod::GET();
    }

    /**
     * @inheritdoc
     */
    public function getUri(): string
    {
        return '/Api/RemovedSubscribers';
    }
}