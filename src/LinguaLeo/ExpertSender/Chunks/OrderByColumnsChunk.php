<?php

namespace LinguaLeo\ExpertSender\Chunks;

class OrderByColumnsChunk extends ArrayChunk
{

    const PATTERN = <<<EOD
<OrderByColumns>
            %s
</OrderByColumns>
EOD;

    /**
     * @return string
     */
    protected function getPattern()
    {
        return self::PATTERN;
    }

} 