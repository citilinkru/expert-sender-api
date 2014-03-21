<?php

namespace LinguaLeo\ExpertSender\Chunks;

class PrimaryKeyColumnsChunk extends ArrayChunk
{

    const PATTERN = <<<EOD
<PrimaryKeyColumns>
            %s
</PrimaryKeyColumns>
EOD;

    protected function getPattern()
    {
        return self::PATTERN;
    }

}