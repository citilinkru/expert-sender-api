<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Chunk;

/**
 * List of where conditions
 *
 * @deprecated Do not use it, this class will be deleted soon
 */
class WhereConditionsChunk extends CompositeChunk
{
    /**
     * @inheritdoc
     */
    protected function getBeforeString(): string
    {
        return '<WhereConditions>';
    }

    /**
     * @inheritdoc
     */
    protected function getAfterString(): string
    {
        return '</WhereConditions>';
    }
}
