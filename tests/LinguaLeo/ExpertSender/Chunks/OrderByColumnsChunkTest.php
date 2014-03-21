<?php

namespace LinguaLeo\ExpertSender\Chunks;

use LinguaLeo\ExpertSender\Entities\OrderBy;
use LinguaLeo\ExpertSender\ExpertSenderEnum;

class OrderByColumnsChunkTest extends \PHPUnit_Framework_TestCase
{

    public function testGetText()
    {
        $orderByChunks = [
            new OrderByChunk(new OrderBy('name', ExpertSenderEnum::ORDER_ASCENDING)),
            new OrderByChunk(new OrderBy('sex', ExpertSenderEnum::ORDER_DESCENDING))
        ];
        $columnsChunk = new OrderByColumnsChunk($orderByChunks);
        $text = $columnsChunk->getText();
        $this->assertContains('<OrderByColumns>', $text);
        $this->assertContains('<OrderBy>', $text);
        $this->assertContains('<Column>name</Column>', $text);
        $this->assertContains('<Direction>Ascending</Direction>', $text);
        $this->assertContains('<Column>sex</Column>', $text);
        $this->assertContains('<Direction>Descending</Direction>', $text);
    }

}
 