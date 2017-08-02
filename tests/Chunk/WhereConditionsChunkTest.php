<?php

namespace Citilink\ExpertSenderApi\Tests\Chunk;

use Citilink\ExpertSenderApi\Chunk\WhereChunk;
use Citilink\ExpertSenderApi\Chunk\WhereConditionsChunk;
use Citilink\ExpertSenderApi\Enum\Operator;

class WhereConditionsChunkTest extends \PHPUnit_Framework_TestCase
{

    public function testGetText()
    {
        $whereChunks = [
            new WhereChunk('name', Operator::EQUAL(), 'Alex'),
            new WhereChunk('sex', Operator::LIKE(), 1),
        ];
        $whereConditionsChunk = new WhereConditionsChunk($whereChunks);
        $text = $whereConditionsChunk->toXml();
        $this->assertContains('<WhereConditions>', $text);
        $this->assertContains('<Where>', $text);
        $this->assertContains('<ColumnName>name</ColumnName>', $text);
        $this->assertContains('<Operator>Equals</Operator>', $text);
        $this->assertContains('<Value>Alex</Value>', $text);
        $this->assertContains('<ColumnName>sex</ColumnName>', $text);
        $this->assertContains('<Operator>Like</Operator>', $text);
        $this->assertContains('<Value>1</Value>', $text);
    }

}
 