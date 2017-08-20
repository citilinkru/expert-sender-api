<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Response;

use Citilink\ExpertSenderApi\Exception\TryToAccessDataFromErrorResponseException;
use Citilink\ExpertSenderApi\SpecificXmlMethodResponse;

/**
 * Response of rows delete
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class DataTablesDeleteRowsPostResponse extends SpecificXmlMethodResponse
{
    /**
     * Get count of deleted rows
     *
     * @return int Count of deleted rows
     */
    public function getCount(): int
    {
        if (!$this->isOk()) {
            throw TryToAccessDataFromErrorResponseException::createFromResponse($this);
        }

        return intval($this->getSimpleXml()->xpath('/ApiResponse/Count')[0]);
    }
}
