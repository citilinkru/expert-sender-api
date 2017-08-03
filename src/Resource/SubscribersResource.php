<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Resource;

use Citilink\ExpertSenderApi\AbstractResource;
use Citilink\ExpertSenderApi\Enum\SubscribersGetRequest\DataOption;
use Citilink\ExpertSenderApi\Model\SubscribersRequest\Options;
use Citilink\ExpertSenderApi\Model\SubscribersRequest\SubscriberInfo;
use Citilink\ExpertSenderApi\Request\SubscribersDeleteRequest;
use Citilink\ExpertSenderApi\Request\SubscribersGetRequest;
use Citilink\ExpertSenderApi\Request\SubscribersPostRequest;
use Citilink\ExpertSenderApi\Response\SubscribersGetFullResponse;
use Citilink\ExpertSenderApi\Response\SubscribersGetLongResponse;
use Citilink\ExpertSenderApi\Response\SubscribersGetShortResponse;
use Citilink\ExpertSenderApi\Response\SubscribersPostResponse;
use Citilink\ExpertSenderApi\ResponseInterface;
use Webmozart\Assert\Assert;

/**
 * Subscribers resource
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class SubscribersResource extends AbstractResource
{
    /**
     * Get short information about subscriber
     *
     * @param string $email Email
     *
     * @return SubscribersGetShortResponse Short information about subscriber
     */
    public function getShort(string $email): SubscribersGetShortResponse
    {
        Assert::notEmpty($email);
        $response = $this->requestSender->send(new SubscribersGetRequest($email, DataOption::SHORT()));

        return new SubscribersGetShortResponse($response);
    }

    /**
     * Get long information of subscriber
     *
     * @param string $email Email
     *
     * @return SubscribersGetLongResponse Long information of subscriber
     */
    public function getLong(string $email): SubscribersGetLongResponse
    {
        Assert::notEmpty($email);
        $response = $this->requestSender->send(new SubscribersGetRequest($email, DataOption::LONG()));

        return new SubscribersGetLongResponse($response);
    }

    /**
     * Get full info about subscriber
     *
     * @param string $email Email
     *
     * @return SubscribersGetFullResponse Full info about subscriber
     */
    public function getFull(string $email): SubscribersGetFullResponse
    {
        Assert::notEmpty($email);
        $response = $this->requestSender->send(new SubscribersGetRequest($email, DataOption::FULL()));

        return new SubscribersGetFullResponse($response);
    }

    /**
     * Get events history of subscriber
     *
     * @param string $email Email
     *
     * @return ResponseInterface Events history of subscriber
     */
    public function getEventHistory(string $email): ResponseInterface
    {
        Assert::notEmpty($email);

        return $this->requestSender->send(new SubscribersGetRequest($email, DataOption::EVENTS_HISTORY()));
    }

    /**
     * Add or edit subscriber
     *
     * @param SubscriberInfo[] $subscriberInfos Subscribers information list
     * @param Options|null $options Options
     *
     * @return SubscribersPostResponse Response
     */
    public function addOrEdit(array $subscriberInfos, Options $options = null): SubscribersPostResponse
    {
        return new SubscribersPostResponse(
            $this->requestSender->send(new SubscribersPostRequest($subscriberInfos, $options))
        );
    }

    /**
     * Delete subscriber by ID
     *
     * @param int $id Subscriber ID
     * @param int|null $listId List ID
     *
     * @return ResponseInterface Response
     */
    public function deleteById(int $id, int $listId = null): ResponseInterface
    {
        return $this->requestSender->send(SubscribersDeleteRequest::createFromId($id, $listId));
    }

    /**
     * Delete subscriber by email
     *
     * @param string $email Subscriber Email
     * @param int|null $listId List ID
     *
     * @return ResponseInterface Response
     */
    public function deleteByEmail(string $email, int $listId = null): ResponseInterface
    {
        return $this->requestSender->send(SubscribersDeleteRequest::createFromEmail($email, $listId));
    }
}
