<?php
namespace LinguaLeo\ExpertSender\Chunks;

use LinguaLeo\ExpertSender\Entities\Receiver;

class ReceiversChunkTest extends \PHPUnit_Framework_TestCase
{
    public function testGetText()
    {
        $receiverChunks = [
            new ReceiverChunk(new Receiver('simple@email.com')),
            new ReceiverChunk(new Receiver(null, 100)),
            new ReceiverChunk(new Receiver('another@email.com', 200))
        ];

        $receiversChunk = new ReceiversChunk($receiverChunks);

        $text = $receiversChunk->getText();

        $this->assertRegExp('~<Id>100</Id>~', $text);
        $this->assertRegExp('~<Email>simple@email.com</Email>~', $text);
        $this->assertRegExp('~<Id>200</Id>[\s]+<Email>another@email.com</Email>~', $text);

    }
}