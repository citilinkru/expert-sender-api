<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Resource;

use Citilink\ExpertSenderApi\AbstractResource;
use Citilink\ExpertSenderApi\Model\TransactionalPostRequest\Attachment;
use Citilink\ExpertSenderApi\Model\TransactionalPostRequest\Snippet;
use Citilink\ExpertSenderApi\Model\TriggersPostRequest\Receiver;
use Citilink\ExpertSenderApi\Model\TransactionalPostRequest\Receiver as TransactionalReceiver;
use Citilink\ExpertSenderApi\Request\TransactionalPostRequest;
use Citilink\ExpertSenderApi\Request\TriggersPostRequest;
use Citilink\ExpertSenderApi\Response\TransactionalPostResponse;
use Citilink\ExpertSenderApi\ResponseInterface;

/**
 * Messages resource
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class MessagesResource extends AbstractResource
{
    /**
     * Send trigger message
     *
     * @param int $triggerMessageId Trigger message ID
     * @param Receiver[] $receivers Receivers
     *
     * @return ResponseInterface Response
     */
    public function sendTriggerMessage(int $triggerMessageId, array $receivers): ResponseInterface
    {
        return $this->requestSender->send(new TriggersPostRequest($triggerMessageId, $receivers));
    }

    /**
     * Send transactional message
     *
     * @param int $transactionMessageId Transaction message ID
     * @param TransactionalReceiver $receiver Receiver
     * @param Snippet[] $snippets Snippets
     * @param Attachment[] $attachments Attachments
     * @param bool $returnGuid Should return GUID in Response
     *
     * @return TransactionalPostResponse Response
     */
    public function sendTransactionalMessage(
        int $transactionMessageId,
        TransactionalReceiver $receiver,
        array $snippets = [],
        array $attachments = [],
        bool $returnGuid = false
    ): TransactionalPostResponse {
        return new TransactionalPostResponse(
            $this->requestSender->send(
                new TransactionalPostRequest(
                    $transactionMessageId, $receiver, $snippets, $attachments, $returnGuid
                )
            )
        );
    }
}
