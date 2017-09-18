<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Request;

use Citilink\ExpertSenderApi\Enum\ActivitiesGetRequest\ActivityType;
use Citilink\ExpertSenderApi\Enum\ActivitiesGetRequest\ReturnColumnsSet;
use Citilink\ExpertSenderApi\Enum\HttpMethod;
use Citilink\ExpertSenderApi\RequestInterface;
use Citilink\ExpertSenderApi\Utils;

/**
 * Get subscriber activity request
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class ActivitiesGetRequest implements RequestInterface
{
    /**
     * @var \DateTime Date
     */
    private $date;

    /**
     * @var ActivityType Activity type
     */
    private $activityType;

    /**
     * @var ReturnColumnsSet
     */
    private $columnSet;

    /**
     * Additional column with link title will be returned
     *
     * This option has no effect for activities other than {@see ActivityType::Clicks}.
     *
     * @var bool
     */
    private $returnTitle;

    /**
     * Additional column with sent message GUID will be returned.
     *
     * This option has no effect for {@see ActivityType::Subscriptions} and {@see ActivityType::Confirmations} activity
     * types.
     *
     * @var bool
     */
    private $returnGuid;

    /**
     * Constructor.
     *
     * @param \DateTime $date Date
     * @param ActivityType $activityType Activity type
     * @param ReturnColumnsSet $columnSet Column set to return ({@see ReturnColumnsSet::STANDARD} by default)
     * @param bool $returnTitle Additional column with link title will be returned. This option has no effect for
     *      activities other than {@see ActivityType::Clicks}.
     * @param bool $returnGuid Additional column with sent message GUID will be returned.. This option has no effect
     *      for {@see ActivityType::Subscriptions} and {@see ActivityType::Confirmations} activity types.
     */
    public function __construct(
        \DateTime $date,
        ActivityType $activityType,
        ReturnColumnsSet $columnSet = null,
        bool $returnTitle = false,
        bool $returnGuid = false
    ) {
        $this->date = $date;
        $this->activityType = $activityType;
        $this->columnSet = $columnSet ?: ReturnColumnsSet::STANDARD();
        $this->returnTitle = $returnTitle;
        $this->returnGuid = $returnGuid;
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
        return [
            'date' => $this->date->format('Y-m-d'),
            'type' => $this->activityType->getValue(),
            'columns' => $this->columnSet->getValue(),
            'returnTitle' => Utils::convertBoolToStringEquivalent($this->returnTitle),
            'returnGuid' => Utils::convertBoolToStringEquivalent($this->returnGuid),
        ];
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
        return '/Api/Activities';
    }
}
