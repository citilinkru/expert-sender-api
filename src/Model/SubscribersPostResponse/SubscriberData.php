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
     * @var string
     */
    private $email;

    /**
     * @var int
     */
    private $id;

    /**
     * @var bool
     */
    private $wasAdded;

    /**
     * @var bool
     */
    private $wasIgnored;

    /**
     * Конструктор.
     *
     * @param string $email
     * @param int $id
     * @param bool $wasAdded
     * @param bool $wasIgnored
     */
    public function __construct(string $email, int $id, bool $wasAdded, bool $wasIgnored)
    {
        $this->email = $email;
        $this->id = $id;
        $this->wasAdded = $wasAdded;
        $this->wasIgnored = $wasIgnored;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isWasAdded(): bool
    {
        return $this->wasAdded;
    }

    /**
     * @return bool
     */
    public function isWasIgnored(): bool
    {
        return $this->wasIgnored;
    }

}
