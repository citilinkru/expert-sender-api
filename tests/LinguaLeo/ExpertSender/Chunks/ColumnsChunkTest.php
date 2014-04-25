<?php

namespace LinguaLeo\ExpertSender\Chunks;

use LinguaLeo\ExpertSender\Entities\Column;

class ColumnsChunkTest extends \PHPUnit_Framework_TestCase
{

    public function testGetText()
    {
        $columnsChunks = [
            new ColumnChunk(new Column('name', 'Alex<br/>Aksef')),
            new ColumnChunk(new Column('sex', 'male')),
            new ColumnChunk(new Column('age', 22))
        ];

        $columnsChunk = new ColumnsChunk($columnsChunks);
        $text = $columnsChunk->getText();
        $this->assertContains('<Columns>', $text);
        $this->assertContains('<Column>', $text);
        $this->assertContains('<Name>name</Name>', $text);
        $this->assertContains('<Value><![CDATA[ Alex<br/>Aksef ]]></Value>', $text);
        $this->assertContains('<Name>sex</Name>', $text);
        $this->assertContains('<Value>male</Value>', $text);
        $this->assertContains('<Name>age</Name>', $text);
        $this->assertContains('<Value>22</Value>', $text);
    }

}
 