<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Chunk;

use Citilink\ExpertSenderApi\ChunkInterface;
use Webmozart\Assert\Assert;

/**
 * Newsletter recipients
 *
 * @deprecated Do not use it, this class will be deleted soon
 */
class RecipientsChunk implements ChunkInterface
{
    /**
     * @var int[] IDs of subscriber lists that newsletter will be sent to
     */
    private $subscriberList = [];

    /**
     * @var int[] IDs of subscriber segments that newsletter will be sent to
     */
    private $subscriberSegments = [];

    /**
     * @var int[] IDs of seed lists used during shipment
     */
    private $seedList = [];

    /**
     * @var int[] ID стоп-листов, которые будут проверены перед отправкой
     */
    private $suppressionLists = [];

    /**
     * Constructor
     *
     * @param int[] $suppressionLists IDs of suppression lists that will be checked during shipment
     * @param int[] $subscriberList IDs of subscriber lists that newsletter will be sent to
     * @param int[] $subscriberSegments IDs of subscriber segments that newsletter will be sent to
     * @param int[] $seedList IDs of seed lists used during shipment
     */
    public function __construct(
        array $suppressionLists,
        array $subscriberList = [],
        array $subscriberSegments = [],
        array $seedList = []
    ) {
        if (empty($subscriberList) && empty($subscriberSegments) && empty($seedList)) {
            throw new \InvalidArgumentException(
                'Must specify subscriberList and/or subscriberSegments and/or seedList'
            );
        }

        Assert::allInteger($suppressionLists);
        Assert::allInteger($subscriberList);
        Assert::allInteger($subscriberSegments);
        Assert::allInteger($seedList);
        Assert::notEmpty($suppressionLists);

        $this->subscriberList = $subscriberList;
        $this->subscriberSegments = $subscriberSegments;
        $this->seedList = $seedList;
        $this->suppressionLists = $suppressionLists;
    }

    /**
     * @inheritdoc
     */
    public function toXml(): string
    {
        $xml = '<Recipients>';
        // todo
        $xml .= '</Recipients>';

        return $xml;
    }
}
