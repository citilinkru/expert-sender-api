<?php
namespace LinguaLeo\ExpertSender\Chunks;

class DataChunkTest extends \PHPUnit_Framework_TestCase
{
    public function testGetText()
    {
        $bodyChunk1 = $this->getMock('stdClass', ['getText']);
        $bodyChunk1->expects($this->once())->method('getText')->will($this->returnValue('data1'));
        $bodyChunk2 = $this->getMock('stdClass', ['getText']);
        $bodyChunk2->expects($this->once())->method('getText')->will($this->returnValue('data2'));

        $dataChunk = new DataChunk('subscriber');
        $dataChunk->addSubChunk($bodyChunk1);
        $dataChunk->addSubChunk($bodyChunk2);

        $text = $dataChunk->getText();
        $this->assertRegExp('~subscriber~', $text);
        $this->assertRegExp('~data1~', $text);
        $this->assertRegExp('~data2~', $text);
    }
}