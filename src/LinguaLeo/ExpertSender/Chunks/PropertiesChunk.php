<?php
namespace LinguaLeo\ExpertSender\Chunks;

class PropertiesChunk implements ChunkInterface
{
    const PATTERN = <<<EOD
        <Properties>
            %s
        </Properties>
EOD;

    protected $propertyChunks;

    public function __construct($propertyChunks = [])
    {
        $this->propertyChunks = $propertyChunks;
    }

    public function addPropertyChunk($propertyChunk)
    {
        $this->propertyChunks[] = $propertyChunk;
    }

    protected function getSubChunksText()
    {
        $texts = [];
        foreach ($this->propertyChunks as $propertyChunk) {
            $texts[] = $propertyChunk->getText();
        }

        return implode("\n", $texts);
    }

    public function getText()
    {
        if (count($this->propertyChunks)) {
            return sprintf(self::PATTERN, $this->getSubChunksText());
        } else {
            return '';
        }
    }
}