<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Model\TransactionalRequest;

/**
 * Receiver of transactional message
 *
 * @see https://sites.google.com/a/expertsender.com/api-documentation/methods/messages/send-transactional-messages
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class Receiver
{
    /**
     * @var int|null Subscriber ID
     */
    private $id;

    /**
     * @var string|null Subscriber email
     */
    private $email;

    /**
     * @var string|null Md5 of subscriber email
     */
    private $emailMd5;

    /**
     * @var int|null List ID
     */
    private $listId;

    /**
     * Create receiver with ID as identifier
     *
     * @param int $id Subscriber ID
     * @param int|null $listId List ID
     *
     * @return static Receiver of message
     */
    public static function createWithId(int $id, int $listId = null)
    {
        return new static($id, null, null, $listId);
    }

    /**
     * Create receiver with email as identifier
     *
     * @param string $email Subscriber email
     * @param int|null $listId List ID
     *
     * @return static Receiver of message
     */
    public static function createWithEmail(string $email, int $listId = null)
    {
        return new static(null, $email, null, $listId);
    }

    /**
     * Create receiver with md5 email as identifier
     *
     * @param string $emailMd5 Md5 of subscriber email
     * @param int|null $listId List ID
     *
     * @return static Receiver of message
     */
    public static function createWithEmailMd5(string $emailMd5, int $listId = null)
    {
        return new static(null, null, $emailMd5, $listId);
    }

    /**
     * Constructor
     *
     * @param int|null $id Subscriber ID
     * @param string|null $email Subscriber Email
     * @param string|null $emailMd5 Md5 of subscriber email
     * @param int|null $listId List ID
     */
    private function __construct(int $id = null, string $email = null, string $emailMd5 = null, int $listId = null)
    {
        // not check anything, because constructor is private and nobody can create invalid object
        $this->id = $id;
        $this->email = $email;
        $this->listId = $listId;
        $this->emailMd5 = $emailMd5;
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

    /**
     * Get Md5 of email
     *
     * @return null|string Md5 of email
     */
    public function getEmailMd5(): ?string
    {
        return $this->emailMd5;
    }

    /**
     * Get list ID
     *
     * @return int|null List ID
     */
    public function getListId(): ?int
    {
        return $this->listId;
    }
}
