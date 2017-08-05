<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Response;

use Citilink\ExpertSenderApi\Exception\TryToAccessDataFromErrorResponseException;
use Citilink\ExpertSenderApi\Model\SubscriberData;
use Citilink\ExpertSenderApi\SubscriberDataParser;

/**
 * Full info about subscriber
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class SubscribersGetFullResponse extends SubscribersGetLongResponse
{
    /**
     * Get subscriber's data
     *
     * @return SubscriberData Subscriber's data
     */
    public function getSubscriberData(): SubscriberData
    {
        if (!$this->isOk()) {
            throw TryToAccessDataFromErrorResponseException::createFromResponse($this);
        }

        return (new SubscriberDataParser())->parse($this->getSimpleXml()->xpath('/ApiResponse/Data')[0]);
    }
}
