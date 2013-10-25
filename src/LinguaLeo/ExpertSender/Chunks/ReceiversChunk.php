<?php
namespace LinguaLeo\ExpertSender\Chunks;

use LinguaLeo\ExpertSender\ExpertSenderException;

class ReceiversChunk implements ChunkInterface
{
    const PATTERN = <<<EOD
<Receivers>
            %s
</Receivers>
EOD;

    protected $receiverChunks;

    public function __construct($receiverChunks = [])
    {
        $this->receiverChunks = $receiverChunks;
    }

    protected function getSubChunksText()
    {
        $texts = [];
        foreach ($this->receiverChunks as $receiverChunk) {

            /** @var ReceiverChunk $receiverChunk */
            $texts[] = $receiverChunk->getText();
        }

        return implode("\n", $texts);
    }

    public function getText()
    {
        if (count($this->receiverChunks)) {
            return sprintf(self::PATTERN, $this->getSubChunksText());
        } else {
            return '';
        }
    }
}