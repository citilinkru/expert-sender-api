<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Exception;

use Citilink\ExpertSenderApi\ResponseInterface;

/**
 * Exception while parse ExpertSender API's response
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class ParseResponseException extends ExpertSenderApiException
{
    /**
     * Constructor
     *
     * @param string $message Message
     * @param ResponseInterface $response Response
     *
     * @return static Exception while parse ExpertSender API's response
     */
    public static function createFromResponse(string $message, ResponseInterface $response)
    {
        return new static(sprintf('%s. Content: [%s]', $message, $response->getContent()));
    }
}
