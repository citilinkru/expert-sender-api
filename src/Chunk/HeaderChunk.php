<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Chunk;

use Citilink\ExpertSenderApi\ChunkInterface;

/**
 * Header chunk
 *
 * @deprecated Do not use it, this class will be deleted soon
 */
class HeaderChunk extends CompositeChunk
{
    /**
     * @var string API key
     */
    private $apiKey;

    /**
     * @param string $apiKey API key
     * @param ChunkInterface[] $chunks Chunks
     */
    public function __construct($apiKey, array $chunks)
    {
        parent::__construct($chunks);
        $this->apiKey = $apiKey;
    }

    /**
     * @inheritdoc
     */
    protected function getBeforeString(): string
    {
        return '<ApiRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" '
            . 'xmlns:xs="http://www.w3.org/2001/XMLSchema">'
            . '<ApiKey>' . $this->apiKey . '</ApiKey>';
    }

    /**
     * @inheritdoc
     */
    protected function getAfterString(): string
    {
        return '</ApiRequest>';
    }
}
