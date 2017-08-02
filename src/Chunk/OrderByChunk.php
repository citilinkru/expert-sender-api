<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Chunk;

use Citilink\ExpertSenderApi\ChunkInterface;
use Citilink\ExpertSenderApi\Enum\SortOrder;

/**
 * Order by chunk
 *
 * @deprecated Do not use it, this class will be deleted soon
 */
class OrderByChunk implements ChunkInterface
{
    /**
     * @var string Column name
     */
    private $columnName;

    /**
     * @var SortOrder Sort order
     */
    private $sortOrder;

    /**
     * Constructor
     *
     * @param string $columnName Column name
     * @param SortOrder $sortOrder Sort order
     */
    public function __construct($columnName, SortOrder $sortOrder)
    {
        $this->columnName = $columnName;
        $this->sortOrder = $sortOrder;
    }

    /**
     * @inheritdoc
     */
    public function toXml(): string
    {
        return '<OrderBy><Column>' . $this->columnName . '</Column><Direction>' . $this->sortOrder->getValue()
            . '</Direction>';
    }
}
