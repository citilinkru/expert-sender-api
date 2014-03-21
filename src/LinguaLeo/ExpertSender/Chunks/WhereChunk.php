<?php

namespace LinguaLeo\ExpertSender\Chunks;

use LinguaLeo\ExpertSender\Entities\Where;

class WhereChunk implements ChunkInterface
{

    const PATTERN = <<<EOD
        <Where>
            %s
        </Where>
EOD;

    /** @var Where */
    private $where;

    /**
     * @param Where $where
     */
    public function __construct(Where $where)
    {
        $this->where = $where;
    }

    /**
     * @return string
     */
    public function getText()
    {
        $text = [];
        $text[] = (new SimpleChunk('ColumnName', $this->where->getColumnName()))->getText();
        $text[] = (new SimpleChunk('Operator', $this->where->getOperator()))->getText();
        $text[] = (new SimpleChunk('Value', $this->where->getValue()))->getText();
        return sprintf(self::PATTERN, implode(PHP_EOL, $text));
    }

} 