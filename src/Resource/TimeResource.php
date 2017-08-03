<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Resource;

use Citilink\ExpertSenderApi\AbstractResource;
use Citilink\ExpertSenderApi\Request\TimeGetRequest;
use Citilink\ExpertSenderApi\Response\TimeGetResponse;

/**
 * Time resource
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class TimeResource extends AbstractResource
{
    /**
     * Get time response
     *
     * @return TimeGetResponse Time response
     */
    public function getTime()
    {
        return new TimeGetResponse($this->requestSender->send(new TimeGetRequest()));
    }
}
