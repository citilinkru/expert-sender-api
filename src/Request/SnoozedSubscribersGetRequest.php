<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Request;

use Citilink\ExpertSenderApi\Enum\HttpMethod;
use Citilink\ExpertSenderApi\RequestInterface;
use Webmozart\Assert\Assert;

/**
 * Request to get snoozed subscribers
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class SnoozedSubscribersGetRequest implements RequestInterface
{
    /**
     * List identifiers
     *
     * If specified, only snoozed subscribers from given lists will be returned. If not specified, snoozed subscribers
     * from all lists will be returned
     *
     * @var int[]
     */
    private $listIds;

    /**
     * Start date
     *
     * If specified, subscribers whose subscription suspension expires prior to this date will not be returned. May
     * be used together with endDate to specify a period of time
     *
     * @var \DateTime|null
     */
    private $startDate;

    /**
     * End date
     *
     * If specified, subscribers whose subscription suspension expires after this date will not be returned. May be
     * used together with startDate to specify a period of time
     *
     * @var \DateTime|null
     */
    private $endDate;

    /**
     * Constructor.
     *
     * @param int[] $listIds List identifiers. If specified, only snoozed subscribers from given lists will be
     * returned. If not specified, snoozed subscribers from all lists will be returned
     * @param \DateTime|null $startDate Start date. If specified, subscribers whose subscription suspension expires
     * prior to this date will not be returned. May be used together with endDate to specify a period of time
     * @param \DateTime|null $endDate End date. If specified, subscribers whose subscription suspension expires after
     *      this date will not be returned. May be used together with startDate to specify a period of time
     */
    public function __construct(array $listIds = [], \DateTime $startDate = null, \DateTime $endDate = null)
    {
        Assert::allInteger($listIds);
        $this->listIds = $listIds;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * {@inheritdoc}
     */
    public function toXml(): string
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function getQueryParams(): array
    {
        $params = [];
        if (!empty($this->listIds)) {
            $params['listIds'] = implode(',', $this->listIds);
        }

        if ($this->startDate !== null) {
            $params['startDate'] = $this->startDate->format('Y-m-d');
        }

        if ($this->endDate !== null) {
            $params['endDate'] = $this->endDate->format('Y-m-d');
        }

        return $params;
    }

    /**
     * {@inheritdoc}
     */
    public function getMethod(): HttpMethod
    {
        return HttpMethod::GET();
    }

    /**
     * {@inheritdoc}
     */
    public function getUri(): string
    {
        return '/v2/Api/SnoozedSubscribers';
    }
}
