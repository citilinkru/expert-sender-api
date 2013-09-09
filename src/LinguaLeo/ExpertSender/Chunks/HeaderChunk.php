<?php
namespace LinguaLeo\ExpertSender\Chunks;

class HeaderChunk implements ChunkInterface
{
    const PATTERN = <<<EOD
<ApiRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns:xs="http://www.w3.org/2001/XMLSchema">
    <ApiKey>%s</ApiKey>
%s
</ApiRequest>
EOD;

    /** @var  ChunkInterface */
    protected $bodyChunk;

    protected $apiKey;

    public function __construct($apiKey, $bodyChunk)
    {
        $this->apiKey = $apiKey;
        $this->bodyChunk = $bodyChunk;
    }

    public function getText()
    {
        return sprintf(self::PATTERN, $this->apiKey, $this->bodyChunk->getText());
    }
}