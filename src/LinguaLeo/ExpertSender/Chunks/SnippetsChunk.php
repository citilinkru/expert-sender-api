<?php
namespace LinguaLeo\ExpertSender\Chunks;

class SnippetsChunk implements ChunkInterface
{
    const PATTERN = <<<EOD
<Snippets>
            %s
</Snippets>
EOD;

    protected $snippetChunks;

    public function __construct($snippetChunks = [])
    {
        $this->snippetChunks = $snippetChunks;
    }

    protected function getSubChunksText()
    {
        $texts = [];
        foreach ($this->snippetChunks as $snippetChunk) {

            /** @var SnippetChunk $snippetChunk */
            $texts[] = $snippetChunk->getText();
        }

        return implode("\n", $texts);
    }

    public function getText()
    {
        if (count($this->snippetChunks)) {
            return sprintf(self::PATTERN, $this->getSubChunksText());
        } else {
            return '';
        }
    }
}