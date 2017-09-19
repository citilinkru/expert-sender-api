<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Request;

use Citilink\ExpertSenderApi\Enum\HttpMethod;
use Citilink\ExpertSenderApi\Enum\SummaryStatisticsGetRequest\GroupByType;
use Citilink\ExpertSenderApi\Model\SummaryStatisticsGetRequest\Scope;
use Citilink\ExpertSenderApi\RequestInterface;

/**
 * Summary statistics get request
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class SummaryStatisticsGetRequest implements RequestInterface
{
    /**
     * @var \DateTime|null Start date. If not specified, business unit creation date will be taken
     */
    private $startDate;

    /**
     * @var \DateTime|null End date. f not specified, current date will be taken
     */
    private $endDate;

    /**
     * Filtering scope.
     *
     * If not specified, no filtering will be applied (data for the whole business unit will be returned)
     *
     * @var Scope|null
     */
    private $scope;

    /**
     * Results grouping.
     *
     * If not specified, results will be grouped by whole business unit (one row of data will be returned with all
     * values summed up)
     *
     * @var GroupByType|null
     */
    private $groupByType;

    /**
     * Constructor.
     *
     * @param Scope|null $scope Filtering scope. If not specified, no filtering will be applied (data for the whole
     *      business unit will be returned)
     * @param GroupByType|null $groupByType Results grouping. If not specified, results will be grouped by whole
     *      business unit (one row of data will be returned with all values summed up)
     * @param \DateTime|null $startDate Start date. If not specified, business unit creation date will be taken
     * @param \DateTime|null $endDate End date. f not specified, current date will be taken
     */
    public function __construct(?Scope $scope, ?GroupByType $groupByType, ?\DateTime $startDate, ?\DateTime $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->scope = $scope;
        $this->groupByType = $groupByType;
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
        if ($this->startDate !== null) {
            $params['startDate'] = $this->startDate->format('Y-m-d');
        }

        if ($this->endDate !== null) {
            $params['endDate'] = $this->endDate->format('Y-m-d');
        }

        if ($this->scope !== null) {
            $params['scope'] = strval($this->scope->getType());
            $params['scopeValue'] = $this->scope->getValue();
        }

        if ($this->groupByType !== null) {
            $params['grouping'] = strval($this->groupByType);
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
        return '/Api/SummaryStatistics';
    }
}
