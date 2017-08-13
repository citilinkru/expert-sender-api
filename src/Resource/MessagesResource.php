<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Resource;

use Citilink\ExpertSenderApi\AbstractResource;
use Citilink\ExpertSenderApi\Model\TriggersPostRequest\Receiver;
use Citilink\ExpertSenderApi\Request\TriggersPostRequest;
use Citilink\ExpertSenderApi\ResponseInterface;

/**
 * Messages resource
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class MessagesResource extends AbstractResource
{
    /**
     * Send triggers messages
     *
     * @param int $triggerMessageId Trigger message ID
     * @param Receiver[] $receivers Receivers
     *
     * @return ResponseInterface Response
     */
    public function sendTriggerMessages(int $triggerMessageId, array $receivers): ResponseInterface
    {
        return $this->requestSender->send(new TriggersPostRequest($triggerMessageId, $receivers));
    }
}
