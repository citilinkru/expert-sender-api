<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Request;

use Citilink\ExpertSenderApi\Enum\HttpMethod;
use Citilink\ExpertSenderApi\RequestInterface;
use Webmozart\Assert\Assert;

/**
 * Snoozed subscribers post request
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class SnoozedSubscribersPostRequest implements RequestInterface
{
    /**
     * Identifier of list the subscriber will be snoozed on
     *
     * If not specified, subscription of all lists will be suspended
     *
     * @var int|null
     */
    private $listId;

    /**
     * @var int|null Subscriber’s unique identifier
     */
    private $id;

    /**
     * @var string|null Subscriber’s email
     */
    private $email;

    /**
     * @var int Number of weeks the subscription will be snoozed for (Valid values are 1 to 26)
     */
    private $snoozeWeeks;

    /**
     * Create request with subscriber's unique identifier to identify subscriber
     *
     * @param int $id Subscriber’s unique identifier
     * @param int $snoozeWeeks Number of weeks the subscription will be snoozed for (Valid values are 1 to 26)
     * @param int|null $listId Identifier of list the subscriber will be snoozed on
     *
     * @return static Snoozed subscribers post request
     */
    public static function createWithId(int $id, int $snoozeWeeks, ?int $listId = null)
    {
        return new static($id, null, $snoozeWeeks, $listId);
    }

    /**
     * Create request with email to identify subscriber
     *
     * @param string $email Subscriber’s email
     * @param int $snoozeWeeks Number of weeks the subscription will be snoozed for (Valid values are 1 to 26)
     * @param int|null $listId Identifier of list the subscriber will be snoozed on
     *
     * @return static Snoozed subscribers post request
     */
    public static function createWithEmail(string $email, int $snoozeWeeks, ?int $listId = null)
    {
        return new static(null, $email, $snoozeWeeks, $listId);
    }

    /**
     * Constructor.
     *
     * @param int|null $id Subscriber’s unique identifier
     * @param string|null $email Subscriber’s email
     * @param int $snoozeWeeks Number of weeks the subscription will be snoozed for (Valid values are 1 to 26)
     * @param int|null $listId Identifier of list the subscriber will be snoozed on
     */
    private function __construct(?int $id, ?string $email, int $snoozeWeeks, ?int $listId = null)
    {
        Assert::greaterThanEq($snoozeWeeks, 1);
        Assert::lessThanEq($snoozeWeeks, 26);

        $this->listId = $listId;
        $this->id = $id;
        $this->email = $email;
        $this->snoozeWeeks = $snoozeWeeks;
    }

    /**
     * {@inheritdoc}
     */
    public function toXml(): string
    {
        $xmlWriter = new \XMLWriter();
        $xmlWriter->openMemory();
        if ($this->id !== null) {
            $xmlWriter->writeElement('Id', (string)$this->id);
        }

        if ($this->email !== null) {
            $xmlWriter->writeElement('Email', $this->email);
        }

        if ($this->listId !== null) {
            $xmlWriter->writeElement('ListId', (string)$this->listId);
        }

        $xmlWriter->writeElement('SnoozeWeeks', (string)$this->snoozeWeeks);

        return $xmlWriter->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getQueryParams(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getMethod(): HttpMethod
    {
        return HttpMethod::POST();
    }

    /**
     * {@inheritdoc}
     */
    public function getUri(): string
    {
        return '/v2/Api/SnoozedSubscribers';
    }
}
