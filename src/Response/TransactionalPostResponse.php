<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Response;

use Citilink\ExpertSenderApi\Exception\TryToAccessDataFromErrorResponseException;
use Citilink\ExpertSenderApi\SpecificMethodResponse;

/**
 * Response of POST request in transactions resource
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class TransactionalPostResponse extends SpecificMethodResponse
{
    /**
     * Get GUID of sent message
     *
     * This GUID only shows when set returnGuid=true in {@see PostTransactionalRequest}
     *
     * @return string|null GUID of sent message
     */
    public function getGuid(): ?string
    {
        if (!$this->isOk()) {
            throw TryToAccessDataFromErrorResponseException::createFromResponse($this);
        }

        $matches = [];
        if (preg_match('#<Data>(.*)</Data>#', $this->getContent(), $matches)) {
            return $matches[1];
        }

        return null;
    }
}
