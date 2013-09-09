<?php
namespace LinguaLeo\ExpertSender\Chunks;

class DataChunk implements ChunkInterface
{
    const PATTERN = <<<EOD
    <Data xsi:type="%s">
%s
    </Data>
EOD;

    protected $xsiType;
    protected $subChunks = [];

    public function __construct($xsiType)
    {
        $this->xsiType = $xsiType;
    }

    public function addSubChunk($chunk)
    {
        $this->subChunks[] = $chunk;
    }

    protected function getSubChunksText()
    {
        $texts = [];
        foreach ($this->subChunks as $subChunk) {
            $texts[] = $subChunk->getText();
        }

        return implode("\n", $texts);
    }

    public function getText()
    {
        return sprintf(self::PATTERN, $this->xsiType, $this->getSubChunksText());
    }
}