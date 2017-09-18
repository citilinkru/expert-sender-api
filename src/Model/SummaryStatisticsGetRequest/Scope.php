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

    public static function createList(int $listId)
    {
        return new static(ScopeType::LIST(), strval($listId));
    }

    public static function createDomain(string $domain)
    {
        return new static(ScopeType::DOMAIN(), $domain);
    }

    public static function createDomainFamily(string $domainFamily)
    {
        return new static(ScopeType::DOMAIN_FAMILY(), $domainFamily);
    }

    public static function createMessageType(MessageType $messageType)
    {
        return new static(ScopeType::MESSAGE_TYPE(), strval($messageType));
    }

    public static function createIp(string $ip)
    {
        return new static(ScopeType::IP(), $ip);
    }

    public static function createSegment(int $segmentId)
    {
        return new static(ScopeType::SEGMENT(), strval($segmentId));
    }

    public static function createVendor(string $vendor)
    {
        return new static(ScopeType::VENDOR(), $vendor);
    }

    public static function createTag(string $tag)
    {
        return new static(ScopeType::TAG(), $tag);
    }

    public static function createSendTimeOptimization(TimeOptimization $optimization)
    {
        return new static(ScopeType::SEND_TIME_OPTIMIZATION(), strval($optimization));
    }

    public static function createTimeTravelOptimization(TimeOptimization $optimization)
    {
        return new static(ScopeType::TIME_TRAVEL_OPTIMIZATION(), strval($optimization));
    }

    public static function createReadingEnvironment(ReadingEnvironment $readingEnvironment)
    {
        return new static(ScopeType::TIME_TRAVEL_OPTIMIZATION(), strval($readingEnvironment));
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
     * @return ScopeType
     */
    public function getType(): ScopeType
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
