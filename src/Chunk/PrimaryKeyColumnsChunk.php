<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Chunk;

use Citilink\ExpertSenderApi\Chunk\CompositeChunk;

/**
 * List of key column chunks
 *
 * @deprecated Do not use it, this class will be deleted soon
 */
class PrimaryKeyColumnsChunk extends CompositeChunk
{
    /**
     * @inheritdoc
     */
    protected function getBeforeString(): string
    {
        return '<PrimaryKeyColumns>';
    }

    /**
     * @inheritdoc
     */
    protected function getAfterString(): string
    {
        return '</PrimaryKeyColumns>';
    }
}
