<?php

namespace Citilink\ExpertSenderApi\Tests\Chunk;

use Citilink\ExpertSenderApi\Chunk\ColumnChunk;
use Citilink\ExpertSenderApi\Chunk\PrimaryKeyColumnsChunk;

/**
 * Class PrimaryKeyColumnsChunkTest
 * @package LinguaLeo\ExpertSender\Chunks
 * @group table-primary-columns
 */
class PrimaryKeyColumnsChunkTest extends \PHPUnit_Framework_TestCase
{

    public function testGetText()
    {
        $columnsChunks = [
            new ColumnChunk('name', 'Alex<br/>'),
            new ColumnChunk('sex', 'male'),
            new ColumnChunk('age', 22)
        ];

        $columnsChunk = new PrimaryKeyColumnsChunk($columnsChunks);
        $text = $columnsChunk->toXml();
        $this->assertContains('<PrimaryKeyColumns>', $text);
        $this->assertContains('<Column>', $text);
        $this->assertContains('<Name>name</Name>', $text);
        $this->assertContains('<Value><![CDATA[Alex<br/>]]></Value>', $text);
        $this->assertContains('<Name>sex</Name>', $text);
        $this->assertContains('<Value>male</Value>', $text);
        $this->assertContains('<Name>age</Name>', $text);
        $this->assertContains('<Value>22</Value>', $text);
    }

}
 