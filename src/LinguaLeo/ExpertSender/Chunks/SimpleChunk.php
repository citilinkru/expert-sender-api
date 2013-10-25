<?php
namespace LinguaLeo\ExpertSender\Chunks;

class SimpleChunk implements ChunkInterface
{
    const PATTERN = <<<EOD
       <%s>%s</%s>
EOD;

    protected $name;
    protected $value;

    public function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    public function getText()
    {
        return sprintf(self::PATTERN, $this->name, $this->value, $this->name);
    }
} 