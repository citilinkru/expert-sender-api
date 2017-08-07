<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Response;

use Citilink\ExpertSenderApi\Model\RemovedSubscribersGetResponse\RemovedSubscriber;
use Citilink\ExpertSenderApi\ResponseInterface;
use Citilink\ExpertSenderApi\SpecificXmlMethodResponse;
use Citilink\ExpertSenderApi\SubscriberDataParser;

/**
 * Response with removed subscribers data
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class RemovedSubscribersGetResponse extends SpecificXmlMethodResponse
{
    /**
     * @var SubscriberDataParser Subscriber data parser
     */
    private $parser;

    /**
     * Constructor
     *
     * @param ResponseInterface $response Response
     */
    public function __construct(ResponseInterface $response)
    {
        parent::__construct($response);

        $this->parser = new SubscriberDataParser();
    }

    /**
     * Get removed subscribers
     *
     * @return RemovedSubscriber[]|\Generator Removed subscribers
     */
    public function getRemovedSubscribers(): \Generator
    {
        $nodes = $this->getSimpleXml()->xpath('/ApiResponse/Data/RemovedSubscribers/RemovedSubscriber');
        foreach ($nodes as $node) {
            $subscriberData = null;
            // check, if additional data exists
            if (strval($node->Id) !== '') {
                $subscriberData = $this->parser->parse($node);
            }

            yield new RemovedSubscriber(
                strval($node->Email),
                intval($node->ListId),
                new \DateTime(strval($node->UnsubscribedOn)),
                $subscriberData
            );
        }
    }
}
