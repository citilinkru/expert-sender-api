<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Model\BouncesGetResponse;

use Citilink\ExpertSenderApi\Enum\BouncesGetResponse\BounceType;

/**
 * Bounce
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class Bounce
{
    /**
     * @var \DateTime Date
     */
    private $date;

    /**
     * @var string Email
     */
    private $email;

    /**
     * @var string Bounce code
     */
    private $bounceCode;

    /**
     * @var BounceType Bounce type
     */
    private $bounceType;

    /**
     * Constructor.
     *
     * @param \DateTime $date Date
     * @param string $email Email
     * @param string $bounceCode Bounce code
     * @param BounceType $bounceType Bounce type
     */
    public function __construct(\DateTime $date, string $email, string $bounceCode, BounceType $bounceType)
    {
        $this->date = $date;
        $this->email = $email;
        $this->bounceCode = $bounceCode;
        $this->bounceType = $bounceType;
    }

    /**
     * Get date
     *
     * @return \DateTime Date
     */
    public function getDate(): \DateTime
    {
        return $this->date;
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
     * Get bounce code
     *
     * @return string Bounce code
     */
    public function getBounceCode(): string
    {
        return $this->bounceCode;
    }

    /**
     * Get bounce type
     *
     * @return BounceType Bounce type
     */
    public function getBounceType(): BounceType
    {
        return $this->bounceType;
    }
}
