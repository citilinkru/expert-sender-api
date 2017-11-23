<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Request;

use Citilink\ExpertSenderApi\Model\TransactionalPostRequest\Attachment;
use Citilink\ExpertSenderApi\Model\TransactionalPostRequest\Snippet;
use Citilink\ExpertSenderApi\Enum\HttpMethod;
use Citilink\ExpertSenderApi\Model\TransactionalPostRequest\Receiver;
use Citilink\ExpertSenderApi\Utils;
use Webmozart\Assert\Assert;

/**
 * Send system transactional message request
 *
 * @author Igor Bozhennikov <bozhennikov.i@citilink.ru>
 */
class SystemTransactionalPostRequest extends TransactionalPostRequest
{
    /**
     * {@inheritdoc}
     */
    public function getUri(): string
    {
        return '/Api/SystemTransactionals/' . $this->transactionMessageId;
    }
}
