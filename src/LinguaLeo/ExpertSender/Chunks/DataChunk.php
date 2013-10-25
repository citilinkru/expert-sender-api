<?php
namespace LinguaLeo\ExpertSender\Chunks;

class DataChunk implements ChunkInterface
{
    const PATTERN = <<<EOD
    <Data %s>
%s
    </Data>
EOD;

    protected $xsiType;
    protected $subChunks = [];

    public function __construct($xsiType = null)
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
        if ($this->xsiType) {
            $xsiType = sprintf('xsi:type="%s"', $this->xsiType);
        } else {
            $xsiType = '';
        }

        return sprintf(self::PATTERN, $xsiType, $this->getSubChunksText());
    }
}