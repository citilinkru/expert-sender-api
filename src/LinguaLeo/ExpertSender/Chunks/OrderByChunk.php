<?php

namespace LinguaLeo\ExpertSender\Chunks;

use LinguaLeo\ExpertSender\Entities\OrderBy;

class OrderByChunk implements ChunkInterface
{

    const PATTERN = <<<EOD
        <OrderBy>
            %s
        </OrderBy>
EOD;

    /** @var OrderBy */
    private $orderBy;

    /**
     * @param OrderBy $orderBy
     */
    public function __construct(OrderBy $orderBy)
    {
        $this->orderBy = $orderBy;
    }

    /**
     * @return string
     */
    public function getText()
    {
        $text = [];
        $text[] = (new SimpleChunk('Column', $this->orderBy->getColumnName()))->getText();
        $text[] = (new SimpleChunk('Direction', $this->orderBy->getDirection()))->getText();
        return sprintf(self::PATTERN, implode(PHP_EOL, $text));
    }

}