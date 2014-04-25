<?php

namespace LinguaLeo\ExpertSender\Chunks;

use LinguaLeo\ExpertSender\Entities\Column;

class ColumnChunk implements ChunkInterface
{

    const PATTERN = <<<EOD
        <Column>
            %s
        </Column>
EOD;

    /** @var Column */
    private $column;

    /**
     * @param Column $column
     */
    public function __construct(Column $column)
    {
        $this->column = $column;
    }

    /**
     * @return string
     */
    public function getText()
    {
        if (!$this->column->hasValue()) {
            return (new SimpleChunk('Column', $this->column->getName()))->getText();
        }
        $text = [];
        $text[] = (new SimpleChunk('Name', $this->column->getName()))->getText();
        $value = $this->column->getValue();
        if ($value != strip_tags($value)) {
            $value = sprintf('<![CDATA[ %s ]]>', $value);
        }
        $text[] = (new SimpleChunk('Value', $value))->getText();
        return sprintf(self::PATTERN, implode(PHP_EOL, $text));
    }

}