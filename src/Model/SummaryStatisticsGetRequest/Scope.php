<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Model\SummaryStatisticsGetRequest;

use Citilink\ExpertSenderApi\Enum\SummaryStatisticsGetRequest\MessageType;
use Citilink\ExpertSenderApi\Enum\SummaryStatisticsGetRequest\ReadingEnvironment;
use Citilink\ExpertSenderApi\Enum\SummaryStatisticsGetRequest\ScopeType;
use Citilink\ExpertSenderApi\Enum\SummaryStatisticsGetRequest\TimeOptimization;

/**
 * Filtering scope
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class Scope
{
    /**
     * @var ScopeType Type
     */
    private $type;

    /**
     * @var string Value
     */
    private $value;

    /**
     * Create filtering scope by list
     *
     * @param int $listId ListId
     *
     * @return static Filtering scope
     */
    public static function createList(int $listId)
    {
        return new static(ScopeType::LIST(), strval($listId));
    }

    /**
     * Create filtering scope by domain
     *
     * @param string $domain Domain name (domain.com)
     *
     * @return static Filtering scope
     */
    public static function createDomain(string $domain)
    {
        return new static(ScopeType::DOMAIN(), $domain);
    }

    /**
     * Create filtering scope by domain family
     *
     * Domain families are specific to each business unit and may be customized. Typical domain families that usually
     * are used (but do not have to apply to your unit!) are: Yahoo, Outlook.com, Gmail, AOL, Other
     *
     * @param string $domainFamily Domain family
     *
     * @return static Filtering scope
     */
    public static function createDomainFamily(string $domainFamily)
    {
        return new static(ScopeType::DOMAIN_FAMILY(), $domainFamily);
    }

    /**
     * Create filtering scope by message type
     *
     * @param MessageType $messageType Message type
     *
     * @return static Filtering scope
     */
    public static function createMessageType(MessageType $messageType)
    {
        return new static(ScopeType::MESSAGE_TYPE(), strval($messageType));
    }

    /**
     * Create filtering scope by IP
     *
     * @param string $ip IP
     *
     * @return static Filtering scope
     */
    public static function createIp(string $ip)
    {
        return new static(ScopeType::IP(), $ip);
    }

    /**
     * Create filtering scope by segment id
     *
     * @param int $segmentId Segment id
     *
     * @return static Filtering scope
     */
    public static function createSegment(int $segmentId)
    {
        return new static(ScopeType::SEGMENT(), strval($segmentId));
    }

    /**
     * Create filtering sctop by vendor
     *
     * @param string $vendor Vendor
     *
     * @return static Filtering scope
     */
    public static function createVendor(string $vendor)
    {
        return new static(ScopeType::VENDOR(), $vendor);
    }

    /**
     * Create filtering scope by tag
     *
     * @param string $tag Tag
     *
     * @return static Filtering scope
     */
    public static function createTag(string $tag)
    {
        return new static(ScopeType::TAG(), $tag);
    }

    /**
     * Create filtering scope by send time optimization
     *
     * @param TimeOptimization $optimization Optimization
     *
     * @return static Filtering scope
     */
    public static function createSendTimeOptimization(TimeOptimization $optimization)
    {
        return new static(ScopeType::SEND_TIME_OPTIMIZATION(), strval($optimization));
    }

    /**
     * Create filtering scope by time travel optimization
     *
     * @param TimeOptimization $optimization Optimization
     *
     * @return static Filtering scope
     */
    public static function createTimeTravelOptimization(TimeOptimization $optimization)
    {
        return new static(ScopeType::TIME_TRAVEL_OPTIMIZATION(), strval($optimization));
    }

    /**
     * Create filtering scope by reading environment
     *
     * @param ReadingEnvironment $readingEnvironment Reading environment
     *
     * @return static Filtering scope
     */
    public static function createReadingEnvironment(ReadingEnvironment $readingEnvironment)
    {
        return new static(ScopeType::READING_ENVIRONMENT(), strval($readingEnvironment));
    }

    /**
     * Constructor.
     *
     * @param ScopeType $type Type
     * @param string $value Value
     */
    protected function __construct(ScopeType $type, string $value)
    {
        $this->type = $type;
        $this->value = $value;
    }

    /**
     * Get scope type
     *
     * @return ScopeType Type
     */
    public function getType(): ScopeType
    {
        return $this->type;
    }

    /**
     * Get value
     *
     * @return string Value
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
