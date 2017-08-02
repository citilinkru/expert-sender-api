<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Resource;

use Citilink\ExpertSenderApi\AbstractResource;
use Citilink\ExpertSenderApi\Enum\SubscribersRequest\Mode;
use Citilink\ExpertSenderApi\Enum\SubscribersRequest\SubscribersGetOption;
use Citilink\ExpertSenderApi\Model\SubscribersRequest\Options;
use Citilink\ExpertSenderApi\Model\SubscribersRequest\SubscriberInfo;
use Citilink\ExpertSenderApi\Request\SubscribersDeleteRequest;
use Citilink\ExpertSenderApi\Request\SubscribersGetRequest;
use Citilink\ExpertSenderApi\Request\SubscribersPostRequest;
use Citilink\ExpertSenderApi\Response\SubscribersGetFullResponse;
use Citilink\ExpertSenderApi\Response\SubscribersGetLongResponse;
use Citilink\ExpertSenderApi\Response\SubscribersGetShortResponse;
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
     * Return short information about subscriber
     *
     * @param string $email Email
     *
     * @return SubscribersGetShortResponse Short information about subscriber
     */
    public function getShort(string $email): SubscribersGetShortResponse
    {
        Assert::notEmpty($email);
        $response = $this->requestSender->send(new SubscribersGetRequest($email, SubscribersGetOption::SHORT()));

        return new SubscribersGetShortResponse($response);
    }

    /**
     * Return long information of subscriber
     *
     * @param string $email Email
     *
     * @return SubscribersGetLongResponse Long information of subscriber
     */
    public function getLong(string $email): SubscribersGetLongResponse
    {
        Assert::notEmpty($email);
        $response = $this->requestSender->send(new SubscribersGetRequest($email, SubscribersGetOption::LONG()));

        return new SubscribersGetLongResponse($response);
    }

    /**
     * Return full info about subscriber
     *
     * @param string $email Email
     *
     * @return SubscribersGetFullResponse Full info about subscriber
     */
    public function getFull(string $email): SubscribersGetFullResponse
    {
        Assert::notEmpty($email);
        $response = $this->requestSender->send(new SubscribersGetRequest($email, SubscribersGetOption::FULL()));

        return new SubscribersGetFullResponse($response);
    }

    /**
     * Return events history of subscriber
     *
     * @param string $email Email
     *
     * @return ResponseInterface Events history of subscriber
     */
    public function getEventHistory(string $email): ResponseInterface
    {
        Assert::notEmpty($email);

        return $this->requestSender->send(new SubscribersGetRequest($email, SubscribersGetOption::EVENTS_HISTORY()));
    }

    /**
     * Add subscriber
     *
     * @param string $email Email
     * @param int $listId List ID
     * @param SubscriberInfo $subscriberInfo Subscriber info
     * @param Mode|null $mode Adding mode
     * @param Options|null $options Options
     *
     * @return ResponseInterface Response
     */
    public function add(
        string $email,
        int $listId,
        SubscriberInfo $subscriberInfo,
        Mode $mode = null,
        Options $options = null
    ) {
        return $this->requestSender->send(
            SubscribersPostRequest::createAddSubscriber($email, $listId, $subscriberInfo, $mode, $options)
        );
    }

    /**
     * Edit subscriber
     *
     * @param string $email Email
     * @param int $listId ListID
     * @param SubscriberInfo $subscriberInfo Subscriber info
     * @param Mode|null $mode Adding mode
     * @param Options|null $options Options
     *
     * @return ResponseInterface Response
     */
    public function editWithEmail(
        string $email,
        int $listId,
        SubscriberInfo $subscriberInfo,
        Mode $mode = null,
        Options $options = null
    ) {
        return $this->requestSender->send(
            SubscribersPostRequest::createEditSubscriberWithEmail($email, $listId, $subscriberInfo, $mode, $options)
        );
    }

    /**
     * Edit subscriber
     *
     * @param string $emailMd5 Md5 of email
     * @param int $listId List ID
     * @param SubscriberInfo $subscriberInfo Subscriber info
     * @param Mode|null $mode Adding mode
     * @param Options|null $options Options
     *
     * @return ResponseInterface Response
     */
    public function editWithEmailMd5(
        string $emailMd5,
        int $listId,
        SubscriberInfo $subscriberInfo,
        Mode $mode = null,
        Options $options = null
    ) {
        return $this->requestSender->send(
            SubscribersPostRequest::createEditSubscriberWithEmailMd5(
                $emailMd5,
                $listId,
                $subscriberInfo,
                $mode,
                $options
            )
        );
    }

    /**
     * Change email
     *
     * @param int $id Subscriber ID
     * @param string $email Email
     * @param int $listId List ID
     * @param Options|null $options Options
     *
     * @return ResponseInterface Response
     */
    public function changeEmail(
        int $id,
        string $email,
        int $listId,
        Options $options = null
    ) {
        return $this->requestSender->send(SubscribersPostRequest::createChangeEmail($id, $email, $listId, $options));
    }

    /**
     * Delete subscriber by ID
     *
     * @param int $id Subscriber ID
     * @param int|null $listId List ID
     *
     * @return ResponseInterface Response
     */
    public function deleteById(int $id, int $listId = null)
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
    public function deleteByEmail(string $email, int $listId = null)
    {
        return $this->requestSender->send(SubscribersDeleteRequest::createFromEmail($email, $listId));
    }
}
