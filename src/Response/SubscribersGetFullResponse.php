<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Response;

use Citilink\ExpertSenderApi\Enum\SubscriberPropertySource;
use Citilink\ExpertSenderApi\Enum\SubscribersResponse\SubscriberPropertyType;
use Citilink\ExpertSenderApi\Exception\ParseResponseException;
use Citilink\ExpertSenderApi\Exception\TryToAccessDataFromErrorResponseException;
use Citilink\ExpertSenderApi\Model\SubscribersGetResponse\SubscriberProperty;
use Citilink\ExpertSenderApi\Model\SubscribersGetResponse\SubscriberPropertyValue;
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
     * @var SubscriberDataParser Subscriber data parser
     */
    private $subscriberDataParser;

    /**
     * Constructor
     *
     * @param ResponseInterface $response Response
     */
    public function __construct(ResponseInterface $response)
    {
        parent::__construct($response);

        if ($this->isOk()) {
            $this->subscriberDataParser = new SubscriberDataParser(
                $this->getSimpleXml()->xpath('/ApiResponse/Data')[0]
            );
        }
    }

    /**
     * Get firstname of subscriber
     *
     * @return string Firstname of subscriber
     */
    public function getFirstname(): string
    {
        if (!$this->isOk()) {
            throw TryToAccessDataFromErrorResponseException::createFromResponse($this);
        }

        return $this->subscriberDataParser->getFirstname();
    }

    /**
     * Get lastname of subscriber
     *
     * @return string Lastname of subscriber
     */
    public function getLastname(): string
    {
        if (!$this->isOk()) {
            throw TryToAccessDataFromErrorResponseException::createFromResponse($this);
        }

        return $this->subscriberDataParser->getLastname();
    }

    /**
     * Get IP of subscriber
     *
     * @return string IP of subscriber
     */
    public function getIp(): string
    {
        if (!$this->isOk()) {
            throw TryToAccessDataFromErrorResponseException::createFromResponse($this);
        }

        return $this->subscriberDataParser->getIp();
    }

    /**
     * Get ID of subscriber
     *
     * @return int ID of subscriber
     */
    public function getId(): int
    {
        if (!$this->isOk()) {
            throw TryToAccessDataFromErrorResponseException::createFromResponse($this);
        }

        return $this->subscriberDataParser->getId();
    }

    /**
     * Get vendor of subscriber
     *
     * @return string Vendor of subscriber
     */
    public function getVendor(): string
    {
        if (!$this->isOk()) {
            throw TryToAccessDataFromErrorResponseException::createFromResponse($this);
        }

        return $this->subscriberDataParser->getVendor();
    }

    /**
     * Get subscriber properties
     *
     * @return SubscriberProperty[] Properties
     */
    public function getProperties(): array
    {
        if (!$this->isOk()) {
            throw TryToAccessDataFromErrorResponseException::createFromResponse($this);
        }

        return $this->subscriberDataParser->getProperties();
    }
}
