<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Model\ActivitiesGetResponse;

/**
 * Confirmation activity
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class ConfirmationActivity extends AbstractActivity
{
    /**
     * @var int List ID
     */
    private $listId;

    /**
     * @var string List name
     */
    private $listName;

    /**
     * Constructor.
     *
     * @param string $email Subscriber's email
     * @param \DateTime $date Confirmation date
     * @param int $listId List ID
     * @param string $listName List name
     */
    public function __construct(string $email, \DateTime $date, int $listId, string $listName)
    {
        parent::__construct($email, $date);
        $this->listId = $listId;
        $this->listName = $listName;
    }

    /**
     * Get List ID
     *
     * @return int List ID
     */
    public function getListId(): int
    {
        return $this->listId;
    }

    /**
     * Get list name
     *
     * @return string List name
     */
    public function getListName(): string
    {
        return $this->listName;
    }
}
