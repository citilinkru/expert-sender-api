<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Model\TriggersPostRequest;

use Webmozart\Assert\Assert;

/**
 * Receiver of trigger message
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class Receiver
{
    /**
     * @var int|null ID
     */
    private $id;

    /**
     * @var string|null Email
     */
    private $email;

    /**
     * Create with ID as identifier
     *
     * @param int $id ID
     *
     * @return static Receiver
     */
    public static function createFromId(int $id)
    {
        Assert::notEmpty($id);

        return new static($id);
    }

    /**
     * Create with email as identifier
     *
     * @param string $email Email
     *
     * @return static Receiver
     */
    public static function createFromEmail(string $email)
    {
        Assert::notEmpty($email);

        return new static(null, $email);
    }

    /**
     * Constructor
     *
     * @param int $id ID
     * @param string $email Email
     */
    private function __construct(int $id = null, string $email = null)
    {
        $this->id = $id;
        $this->email = $email;
    }

    /**
     * Get ID
     *
     * @return int|null ID
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get email
     *
     * @return null|string Email
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }
}
