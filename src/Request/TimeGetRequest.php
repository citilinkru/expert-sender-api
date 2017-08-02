<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Request;

use Citilink\ExpertSenderApi\Enum\HttpMethod;
use Citilink\ExpertSenderApi\RequestInterface;

/**
 * Request to get server time
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class TimeGetRequest implements RequestInterface
{
    /**
     * @inheritdoc
     */
    public function toXml(): string
    {
        return '';
    }

    /**
     * @inheritdoc
     */
    public function getMethod(): HttpMethod
    {
        return HttpMethod::GET();
    }

    /**
     * @inheritdoc
     */
    public function getUri(): string
    {
        return '/Api/Time';
    }

    /**
     * @inheritdoc
     */
    public function getQueryParams(): array
    {
        return [];
    }
}
