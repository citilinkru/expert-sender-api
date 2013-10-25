<?php
namespace LinguaLeo\ExpertSender\Chunks;

use LinguaLeo\ExpertSender\Entities\Snippet;
use LinguaLeo\ExpertSender\ExpertSenderException;

class SnippetChunk implements ChunkInterface
{
    const PATTERN = <<<EOD
        <Snippet>
            <Name>%s</Name>
            <Value>%s</Value>
        </Snippet>
EOD;

    /** @var Snippet */
    protected $snippet;

    public function __construct($snippet)
    {
        if (!$snippet instanceof Snippet) {
            throw new ExpertSenderException("Snippet parameter must be instance of Snippet class");
        }

        $this->snippet = $snippet;
    }

    public function getText()
    {
        return sprintf(self::PATTERN, $this->snippet->getName(), $this->snippet->getValue());
    }
}