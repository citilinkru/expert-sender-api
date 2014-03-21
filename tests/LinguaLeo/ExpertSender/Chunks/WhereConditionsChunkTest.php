<?php

namespace LinguaLeo\ExpertSender\Chunks;

use LinguaLeo\ExpertSender\Entities\Where;
use LinguaLeo\ExpertSender\ExpertSenderEnum;

class WhereConditionsChunkTest extends \PHPUnit_Framework_TestCase
{

    public function testGetText()
    {
        $whereChunks = [
            new WhereChunk(new Where('name', ExpertSenderEnum::OPERATOR_EQUALS, 'Alex')),
            new WhereChunk(new Where('sex', ExpertSenderEnum::OPERATOR_LIKE, 1)),
        ];
        $whereConditionsChunk = new WhereConditionsChunk($whereChunks);
        $text = $whereConditionsChunk->getText();
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
 