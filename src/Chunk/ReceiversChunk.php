<?php
declare(strict_types=1);


namespace Citilink\ExpertSenderApi\Chunk;

/**
 * List of receiver chunks
 *
 * @deprecated Do not use it, this class will be deleted soon
 */
class ReceiversChunk extends CompositeChunk
{
    /**
     * @inheritdoc
     */
    protected function getBeforeString(): string
    {
        return '<Receivers>';
    }

    /**
     * @inheritdoc
     */
    protected function getAfterString(): string
    {
        return '</Receivers>';
    }
}
