<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Response;

use Citilink\ExpertSenderApi\Exception\TryToAccessDataFromErrorResponseException;
use Citilink\ExpertSenderApi\SpecificXmlMethodResponse;

/**
 * Response with count info
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class CountResponse extends SpecificXmlMethodResponse
{
    /**
     * Get count
     *
     * @return int Count
     */
    public function getCount(): int
    {
        if (!$this->isOk()) {
            throw TryToAccessDataFromErrorResponseException::createFromResponse($this);
        }

        return intval($this->getSimpleXml()->xpath('/ApiResponse/Count')[0]);
    }
}
