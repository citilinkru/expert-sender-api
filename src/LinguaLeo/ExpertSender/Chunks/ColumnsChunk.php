<?php

namespace LinguaLeo\ExpertSender\Chunks;

class ColumnsChunk extends ArrayChunk
{

    const PATTERN = <<<EOD
<Columns>
            %s
</Columns>
EOD;

    protected function getPattern()
    {
        return self::PATTERN;
    }

}