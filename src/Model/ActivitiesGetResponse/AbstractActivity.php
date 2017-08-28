<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Model\ActivitiesGetResponse;

/**
 * Subscriber's activity
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
abstract class AbstractActivity
{
    /**
     * @var string Subscriber's email
     */
    private $email;

    /**
     * @var \DateTime Subscription date
     */
    private $date;

    /**
     * AbstractActivity constructor.
     *
     * @param string $email Subscriber's email
     * @param \DateTime $date Subscription date
     */
    public function __construct(string $email, \DateTime $date)
    {
        $this->email = $email;
        $this->date = $date;
    }

    /**
     * Get subscriber's email
     *
     * @return string Subscriber's email
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * Get subscription date
     *
     * @return \DateTime Subscription date
     */
    public function getDate(): \DateTime
    {
        return $this->date;
    }
}
