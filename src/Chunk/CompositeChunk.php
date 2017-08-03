<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Chunk;

use Citilink\ExpertSenderApi\ChunkInterface;
use Webmozart\Assert\Assert;

/**
 * Composite chunk
 *
 * Consist of another chunks
 *
 * @deprecated Do not use it, this class will be deleted soon
 */
class CompositeChunk implements ChunkInterface
{
    /**
     * @var ChunkInterface[] Chunks
     */
    protected $chunks = [];

    /**
     * Constructor
     *
     * @param ChunkInterface[] $chunks Chunks
     */
    public function __construct(array $chunks = [])
    {
        Assert::allIsInstanceOf($chunks, ChunkInterface::class);
        $this->chunks = $chunks;
    }

    /**
     * @inheritdoc
     */
    public function toXml(): string
    {
        if (empty($this->chunks)) {
            return '';
        }

        $xml = $this->getBeforeString();
        foreach ($this->chunks as $columnChunk) {
            $xml .= $columnChunk->toXml();
        }

        $xml .= $this->getAfterString();

        return $xml;
    }

    /**
     * Get string, that insert before all chunks as xml
     *
     * @return string String, that insert before all chunks as xml
     */
    protected function getBeforeString(): string
    {
        return '';
    }

    /**
     * Get string, that insert after all chunks as xml
     *
     * @return string String, that insert after all chunks as xml
     */
    protected function getAfterString(): string
    {
        return '';
    }
}
