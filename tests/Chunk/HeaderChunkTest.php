<?php
namespace Citilink\ExpertSenderApi\Tests\Chunk;

use Citilink\ExpertSenderApi\Chunk\HeaderChunk;
use Citilink\ExpertSenderApi\Chunk\SimpleChunk;

class HeaderChunkTest extends \PHPUnit_Framework_TestCase
{
    public function testGetText()
    {
        $bodyChunk = new SimpleChunk('name', 'body');
        $headerChunk = new HeaderChunk('api-key', [$bodyChunk]);
        $text = $headerChunk->toXml();

        $this->assertRegExp('~body~', $text);
        $this->assertRegExp('~api-key~', $text);
    }
}
