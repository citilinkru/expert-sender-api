<?php
namespace LinguaLeo\ExpertSender\Chunks;

class PropertyChunk implements ChunkInterface
{
    const PATTERN = <<<EOD
        <Property>
             <Id>%s</Id>
             <Value xsi:type="xs:%s">%s</Value>
        </Property>
EOD;

    /** @var Property */
    protected $property;
    protected $type;
    protected $value;

    public function __construct($property)
    {
        $this->property = $property;
    }

    public function getText()
    {
        return sprintf(self::PATTERN, $this->property->getId(), $this->property->getType(), $this->property->getValue());
    }
}