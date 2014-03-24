<?php
namespace LinguaLeo\ExpertSender\Chunks;

class HeaderChunkTest extends \PHPUnit_Framework_TestCase
{
    public function testGetText()
    {
        $bodyChunk = $this->getMock('LinguaLeo\ExpertSender\Chunks\SimpleChunk', ['getText'], [], '', false);
        $bodyChunk->expects($this->once())->method('getText')->will($this->returnValue('body'));

        $headerChunk = new HeaderChunk('api-key', $bodyChunk);
        $text = $headerChunk->getText();

        $this->assertRegExp('~body~', $text);
        $this->assertRegExp('~api-key~', $text);
    }
}