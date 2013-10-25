<?php
namespace LinguaLeo\ExpertSender\Chunks;

use LinguaLeo\ExpertSender\Entities\Receiver;
use LinguaLeo\ExpertSender\ExpertSenderException;

class ReceiverChunk implements ChunkInterface
{
    const PATTERN = <<<EOD
        <Receiver>
            %s
        </Receiver>
EOD;

    /** @var Receiver */
    protected $receiver;

    public function __construct($receiver)
    {
        if (!$receiver instanceof Receiver) {
            throw new ExpertSenderException("Receiver parameter must be instance of Receiver class");
        }

        $this->receiver = $receiver;
    }

    public function getText()
    {
        $textStrings = [];

        if ($this->receiver->getId() != null) {
            $chunk = new SimpleChunk('Id', $this->receiver->getId());
            $textStrings[] =  $chunk->getText();
        }

        if ($this->receiver->getEmail() != null) {
            $chunk = new SimpleChunk('Email', $this->receiver->getEmail());
            $textStrings[] =  $chunk->getText();
        }

        return sprintf(self::PATTERN, implode(PHP_EOL, $textStrings));
    }
}