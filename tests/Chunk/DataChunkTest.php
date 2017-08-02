<?php
namespace Citilink\ExpertSenderApi\Tests\Chunk;

use Citilink\ExpertSenderApi\Chunk\DataChunk;
use Citilink\ExpertSenderApi\Chunk\SimpleChunk;

class DataChunkTest extends \PHPUnit_Framework_TestCase
{
    public function testGetText()
    {
        $bodyChunk1 = new SimpleChunk('name', 'data1');
        $bodyChunk2 = new SimpleChunk('name', 'data2');

        $dataChunk = new DataChunk([$bodyChunk1, $bodyChunk2], 'subscriber');

        $text = $dataChunk->toXml();
        $this->assertRegExp('~subscriber~', $text);
        $this->assertRegExp('~data1~', $text);
        $this->assertRegExp('~data2~', $text);
    }
}
