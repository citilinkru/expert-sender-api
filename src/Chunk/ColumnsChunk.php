<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Chunk;

use Webmozart\Assert\Assert;

/**
 * Columns list
 *
 * @deprecated Do not use it, this class will be deleted soon
 */
class ColumnsChunk extends CompositeChunk
{
    /**
     * Constructor
     *
     * @param ColumnChunk[] $columnChunks Columns
     */
    public function __construct(array $columnChunks)
    {
        Assert::allIsInstanceOf($columnChunks, ColumnChunk::class);
        parent::__construct($columnChunks);
    }

    /**
     * @inheritdoc
     */
    protected function getBeforeString(): string
    {
        return '<Columns>';
    }

    /**
     * @inheritdoc
     */
    protected function getAfterString(): string
    {
        return '</Columns>';
    }
}
