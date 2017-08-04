<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Model\SubscribersPostRequest;

use Citilink\ExpertSenderApi\Enum\SubscribersPostRequest\MatchingMode;
use Citilink\ExpertSenderApi\Exception\ExpertSenderApiException;

/**
 * Identifier of subscriber for add/edit request
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class Identifier
{
    /**
     * @var MatchingMode Matching mode
     */
    private $matchingMode;

    /**
     * @var string|null Email
     */
    private $email;

    /**
     * @var string|null Md5 of email
     */
    private $emailMd5;

    /**
     * @var string|null Phone
     */
    private $phone;

    /**
     * @var int|null ID
     */
    private $id;

    /**
     * @var string|null Custom subscriber ID
     */
    private $customSubscriberId;

    /**
     * Create email identifier
     *
     * @param string $email Email
     *
     * @return static Identifier of subscriber for add/edit request
     */
    public static function createEmail(string $email)
    {
        return new static(MatchingMode::EMAIL(), $email);
    }

    /**
     * Create md5 of email identifier
     *
     * @param string $emailMd5 Md5 of email
     *
     * @return static Identifier of subscriber for add/edit request
     */
    public static function createEmailMd5(string $emailMd5)
    {
        return new static(MatchingMode::EMAIL(), null, $emailMd5);
    }

    /**
     * Create ID identifier
     *
     * @param int $id ID
     *
     * @return static Identifier of subscriber for add/edit request
     */
    public static function createId(int $id)
    {
        return new static(MatchingMode::ID(), null, null, null, $id);
    }

    /**
     * Create phone identifier
     *
     * @param string $phone Phone
     *
     * @return static Identifier of subscriber for add/edit request
     */
    public static function createPhone(string $phone)
    {
        return new static(MatchingMode::PHONE(), null, null, $phone);
    }

    /**
     * Create custom subscriber ID identifier
     *
     * @param string $customSubscriberId Custom subscriber ID
     *
     * @return static Identifier of subscriber for add/edit request
     */
    public static function createCustomSubscriberId(string $customSubscriberId)
    {
        return new static(MatchingMode::CUSTOMER_SUBSCRIBER_ID(), null, null, null, null, $customSubscriberId);
    }

    /**
     * Constructor.
     *
     * @param MatchingMode $matchingMode Matching mode
     * @param string $email Email
     * @param string $emailMd5 Md5 of email
     * @param string $phone Phone
     * @param int $id ID
     * @param string $customSubscriberId Custom subscriber ID
     */
    private function __construct(
        MatchingMode $matchingMode,
        string $email = null,
        string $emailMd5 = null,
        string $phone = null,
        int $id = null,
        string $customSubscriberId = null
    ) {
        $this->matchingMode = $matchingMode;
        $this->email = $email;
        $this->emailMd5 = $emailMd5;
        $this->phone = $phone;
        $this->id = $id;
        $this->customSubscriberId = $customSubscriberId;
    }

    /**
     * Get matching mode
     *
     * @return MatchingMode Matching mode
     */
    public function getMatchingMode(): MatchingMode
    {
        return $this->matchingMode;
    }

    /**
     * Get email
     *
     * In matching mode == 'Email' one of values email or emailMd5 is not null
     *
     * @return string|null Email
     */
    public function getEmail(): ?string
    {
        if (!$this->matchingMode->equals(MatchingMode::EMAIL())) {
            throw new ExpertSenderApiException(
                sprintf(
                    'Can\'t use getEmail method, because Matching mode is "%s", if you want use email as'
                    . ' identifier create object with static method createEmail',
                    $this->matchingMode->getValue()
                )
            );
        }

        return $this->email;
    }

    /**
     * Return md5 of email
     *
     * In matching mode == 'Email' one of values email or emailMd5 is not null
     *
     * @return string Md5 of email
     */
    public function getEmailMd5(): ?string
    {
        if (!$this->matchingMode->equals(MatchingMode::EMAIL())) {
            throw new ExpertSenderApiException(
                sprintf(
                    'Can\'t use getEmailMd5 method, because Matching mode is "%s", if you want use md5 of '
                    . 'email as identifier create object with static method createEmailMd5',
                    $this->matchingMode->getValue()
                )
            );
        }

        return $this->emailMd5;
    }

    /**
     * Get phone
     *
     * @return string Phone
     */
    public function getPhone(): string
    {
        if (!$this->matchingMode->equals(MatchingMode::PHONE())) {
            throw new ExpertSenderApiException(
                sprintf(
                    'Can\'t use getPhone method, because Matching mode is "%s", if you want use phone as'
                    . ' identifier create object with static method createPhone',
                    $this->matchingMode->getValue()
                )
            );
        }

        return $this->phone;
    }

    /**
     * Get ID
     *
     * @return int ID
     */
    public function getId(): int
    {
        if (!$this->matchingMode->equals(MatchingMode::ID())) {
            throw new ExpertSenderApiException(
                sprintf(
                    'Can\'t use getId method, because Matching mode is "%s", if you want use id as'
                    . ' identifier create object with static method createId',
                    $this->matchingMode->getValue()
                )
            );
        }

        return $this->id;
    }

    /**
     * Get custom subscriber ID
     *
     * @return string Custom subscriber ID
     */
    public function getCustomSubscriberId(): string
    {
        if (!$this->matchingMode->equals(MatchingMode::CUSTOMER_SUBSCRIBER_ID())) {
            throw new ExpertSenderApiException(
                sprintf(
                    'Can\'t use getCustomSubscriberId method, because Matching mode is "%s", if you want use '
                    . 'custom subscriber id as identifier create object with static method createCustomSubscriberId',
                    $this->matchingMode->getValue()
                )
            );
        }

        return $this->customSubscriberId;
    }
}
