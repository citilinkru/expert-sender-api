<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Chunk;

use Citilink\ExpertSenderApi\Chunk\CompositeChunk;

/**
 * List of all order by column chunks
 *
 * @deprecated Do not use it, this class will be deleted soon
 */
class OrderByColumnsChunk extends CompositeChunk
{
    /**
     * @inheritdoc
     */
    protected function getBeforeString(): string
    {
        return '<OrderByColumns>';
    }

    /**
     * @inheritdoc
     */
    protected function getAfterString(): string
    {
        return '</OrderByColumns>';
    }
}
