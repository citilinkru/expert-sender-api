<?php

namespace LinguaLeo\ExpertSender\Chunks;

class GroupChunkTest extends \PHPUnit_Framework_TestCase
{

    public function testGetText()
    {
        $groupChunk = new GroupChunk();
        $groupChunk->addChunk(new SimpleChunk('Name', 'Alex'));
        $groupChunk->addChunk(new SimpleChunk('Age', 22));
        $text = $groupChunk->getText();
        $this->assertContains('<Name>Alex</Name>', $text);
        $this->assertContains('<Age>22</Age>', $text);
    }

}
 