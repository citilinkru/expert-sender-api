<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Chunk;

use Citilink\ExpertSenderApi\ChunkInterface;

/**
 * Data chunk
 *
 * @deprecated Do not use it, this class will be deleted soon
 */
class DataChunk extends CompositeChunk
{
    /**
     * @var string XSI type
     */
    protected $xsiType;

    /**
     * Constructor
     *
     * @param ChunkInterface[] $chunks Chunks
     * @param string $xsiType XSI type
     */
    public function __construct(array $chunks, string $xsiType = null)
    {
        parent::__construct($chunks);
        $this->xsiType = $xsiType;
    }

    /**
     * @inheritdoc
     */
    protected function getBeforeString(): string
    {
        $xml = '<Data';
        if (!empty($this->xsiType)) {
            $xml .= ' xsi:type="' . $this->xsiType . '"';
        }

        $xml .= '>';

        return $xml;
    }

    /**
     * @inheritdoc
     */
    protected function getAfterString(): string
    {
        return '</Data>';
    }
}
