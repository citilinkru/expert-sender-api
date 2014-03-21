<?php
namespace LinguaLeo\ExpertSender\Chunks;

class DataChunk extends ArrayChunk
{

    const PATTERN = <<<EOD
    <Data %s>
%s
    </Data>
EOD;

    /** @var string */
    protected $xsiType;

    /**
     * @param mixed $xsiType
     * @param array $chunksArray
     */
    public function __construct($xsiType = null, array $chunksArray = [])
    {
        parent::__construct($chunksArray);
        $this->xsiType = $xsiType;
    }

    /**
     * @return string
     */
    public function getText()
    {
        $xsiType = $this->xsiType ? sprintf('xsi:type="%s"', $this->xsiType) : '';
        return sprintf($this->getPattern(), $xsiType, $this->getSubChunksText());
    }

    /**
     * @return string
     */
    protected function getPattern()
    {
        return self::PATTERN;
    }

}