<?php

namespace LinguaLeo\ExpertSender\Chunks;

class GroupChunk implements ChunkInterface
{

    /** @var ChunkInterface[] */
    protected $chunks = [];

    /**
     * @param ChunkInterface[] $chunks
     */
    public function __construct(array $chunks = [])
    {
        $this->chunks = $chunks;
    }

    /**
     * @param ChunkInterface $chunk
     */
    public function addChunk(ChunkInterface $chunk)
    {
        $this->chunks[] = $chunk;
    }

    /**
     * @return string
     */
    public function getText()
    {
        $text = [];
        foreach ($this->chunks as $chunk) {
            $text[] = $chunk->getText();
        }
        return implode(PHP_EOL, $text);
    }

}