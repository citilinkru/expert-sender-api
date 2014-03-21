<?php

namespace LinguaLeo\ExpertSender\Chunks;

abstract class ArrayChunk implements ChunkInterface
{

    /** @var array */
    protected $chunks = [];

    /**
     * @param ChunkInterface[] $chunksArray
     */
    public function __construct(array $chunksArray = [])
    {
        $this->chunks = $chunksArray;
    }

    /**
     * @param ChunkInterface $chunk
     */
    public function addChunk($chunk)
    {
        $this->chunks[] = $chunk;
    }

    /**
     * @return string
     */
    protected function getSubChunksText()
    {
        $texts = [];
        foreach ($this->chunks as $columnChunk) {
            /** @var ChunkInterface $columnChunk */
            $texts[] = $columnChunk->getText();
        }
        return implode("\n", $texts);
    }

    /**
     * @return string
     */
    public function getText()
    {
        return $this->chunks ? sprintf($this->getPattern(), $this->getSubChunksText()) : '';
    }

    /**
     * @return string
     */
    abstract protected function getPattern();

} 