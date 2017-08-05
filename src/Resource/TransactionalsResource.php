<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Resource;

use Citilink\ExpertSenderApi\AbstractResource;
use Citilink\ExpertSenderApi\Model\TransactionalRequest\Attachment;
use Citilink\ExpertSenderApi\Model\TransactionalRequest\Receiver;
use Citilink\ExpertSenderApi\Model\TransactionalRequest\Snippet;
use Citilink\ExpertSenderApi\Request\TransactionalPostRequest;
use Citilink\ExpertSenderApi\Response\TransactionalPostResponse;

/**
 * Transactionals resource
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class TransactionalsResource extends AbstractResource
{
    /**
     * Send transactional message
     *
     * @param int $transactionMessageId Transaction message ID
     * @param Receiver $receiver Receiver
     * @param Snippet[] $snippets Snippets
     * @param Attachment[] $attachments Attachments
     * @param bool $returnGuid Should return GUID in Response
     *
     * @return TransactionalPostResponse Response
     */
    public function send(
        int $transactionMessageId,
        Receiver $receiver,
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
