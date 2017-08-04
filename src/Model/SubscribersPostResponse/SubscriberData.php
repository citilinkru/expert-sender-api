<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Model\SubscribersPostResponse;

/**
 * Subscriber info after add/edit
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class SubscriberData
{
    /**
     * @var string Email
     */
    private $email;

    /**
     * @var int ID
     */
    private $id;

    /**
     * @var bool Subscriber was added
     */
    private $isWasAdded;

    /**
     * @var bool Subscriber was ignored
     */
    private $isWasIgnored;

    /**
     * Constructor.
     *
     * @param string $email Email
     * @param int $id Id
     * @param bool $isWasAdded Subscriber was added
     * @param bool $isWasIgnored Subscriber was ignored
     */
    public function __construct(string $email, int $id, bool $isWasAdded, bool $isWasIgnored)
    {
        $this->email = $email;
        $this->id = $id;
        $this->isWasAdded = $isWasAdded;
        $this->isWasIgnored = $isWasIgnored;
    }

    /**
     * Get email
     *
     * @return string Email
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Get ID
     *
     * @return int ID
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Is subscriber was added
     *
     * @return bool Is subscriber was added
     */
    public function isWasAdded(): bool
    {
        return $this->isWasAdded;
    }

    /**
     * Is subscriber was ignored
     *
     * @return bool Is subscriber was ignored
     */
    public function isWasIgnored(): bool
    {
        return $this->isWasIgnored;
    }
}
