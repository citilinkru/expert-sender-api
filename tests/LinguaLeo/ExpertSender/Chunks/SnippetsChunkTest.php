<?php
namespace LinguaLeo\ExpertSender\Chunks;

use LinguaLeo\ExpertSender\Entities\Snippet;

class SnippetsChunkTest extends \PHPUnit_Framework_TestCase
{
    public function testGetText()
    {
        $snippetChunks = [
            new SnippetChunk(new Snippet('test', 'value')),
            new SnippetChunk(new Snippet('cdata', '<tag>ok</tag>', true)),
        ];

        $receiversChunk = new ReceiversChunk($snippetChunks);

        $text = $receiversChunk->getText();

        $this->assertRegExp('~<Name>test</Name>[\s]+<Value>value</Value>~', $text);
        $this->assertRegExp('~<Name>cdata</Name>[\s]+<Value>[\s\S]+CDATA[\s\S]+<tag>ok</tag>[\s\S]+</Value>~', $text);

    }
}