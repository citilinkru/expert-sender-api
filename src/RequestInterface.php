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
     * Return XML representation
     *
     * @return string XML representation
     */
    public function toXml(): string;

    /**
     * Return query parameters
     *
     * @return string[] Query parameters
     */
    public function getQueryParams(): array;

    /**
     * Return HTTP method
     *
     * @return HttpMethod HTTP method
     */
    public function getMethod(): HttpMethod;

    /**
     * Return URI
     *
     * @return string URI
     */
    public function getUri(): string;
}
