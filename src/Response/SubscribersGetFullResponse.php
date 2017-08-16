<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Response;

use Citilink\ExpertSenderApi\Exception\TryToAccessDataFromErrorResponseException;
use Citilink\ExpertSenderApi\Model\SubscriberData;
use Citilink\ExpertSenderApi\ResponseInterface;
use Citilink\ExpertSenderApi\SubscriberDataParser;

/**
 * Full info about subscriber
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class SubscribersGetFullResponse extends SubscribersGetLongResponse
{
    /**
     * @var SubscriberDataParser Subscriber data parse
     */
    private $parser;

    /**
     * Constructor
     *
     * @param ResponseInterface $response Response of ExpertSender API
     */
    public function __construct(ResponseInterface $response)
    {
        parent::__construct($response);

        $this->parser = new SubscriberDataParser();
    }

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

        return $this->parser->parse($this->getSimpleXml()->xpath('/ApiResponse/Data')[0]);
    }
}
