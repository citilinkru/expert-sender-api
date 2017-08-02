<?php

namespace Citilink\ExpertSenderApi\Tests\Chunk;

use Citilink\ExpertSenderApi\Chunk\OrderByChunk;
use Citilink\ExpertSenderApi\Chunk\OrderByColumnsChunk;
use Citilink\ExpertSenderApi\Enum\SortOrder;

class OrderByColumnsChunkTest extends \PHPUnit_Framework_TestCase
{

    public function testGetText()
    {
        $orderByChunks = [
            new OrderByChunk('name', SortOrder::ASCENDING()),
            new OrderByChunk('sex', SortOrder::DESCENDING()),
        ];
        $columnsChunk = new OrderByColumnsChunk($orderByChunks);
        $text = $columnsChunk->toXml();
        $this->assertContains('<OrderByColumns>', $text);
        $this->assertContains('<OrderBy>', $text);
        $this->assertContains('<Column>name</Column>', $text);
        $this->assertContains('<Direction>Ascending</Direction>', $text);
        $this->assertContains('<Column>sex</Column>', $text);
        $this->assertContains('<Direction>Descending</Direction>', $text);
    }

}
 