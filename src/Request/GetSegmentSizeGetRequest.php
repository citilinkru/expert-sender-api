<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Request;

use Citilink\ExpertSenderApi\Enum\HttpMethod;
use Citilink\ExpertSenderApi\RequestInterface;

/**
 * Request for GET /Api/GetSegmentSize
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class GetSegmentSizeGetRequest implements RequestInterface
{
    /**
     * @var int Segment ID
     */
    private $segmentId;

    /**
     * Constructor.
     *
     * @param int $segmentId Segment ID
     */
    public function __construct($segmentId)
    {
        $this->segmentId = $segmentId;
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
        return ['id' => $this->segmentId];
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
        return '/Api/GetSegmentSize';
    }
}