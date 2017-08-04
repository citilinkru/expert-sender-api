<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi;

use Citilink\ExpertSenderApi\Enum\HttpMethod;

/**
 * ExpertSender API Response
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
interface RequestInterface
{
    /**
     * Get XML representation
     *
     * @return string XML representation
     */
    public function toXml(): string;

    /**
     * Get query parameters
     *
     * @return string[] Query parameters
     */
    public function getQueryParams(): array;

    /**
     * Get HTTP method
     *
     * @return HttpMethod HTTP method
     */
    public function getMethod(): HttpMethod;

    /**
     * Get URI
     *
     * @return string URI
     */
    public function getUri(): string;
}
