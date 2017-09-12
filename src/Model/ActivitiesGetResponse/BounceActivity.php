<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Model\ActivitiesGetResponse;

use Citilink\ExpertSenderApi\Enum\ActivitiesGetRequest\BounceReason;

/**
 * Bounce activity
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class BounceActivity extends AbstractActivity
{
    /**
     * @var int|null List ID. Exists only if with extended column set
     */
    private $listId;

    /**
     * @var string|null List name. Exists only if with extended column set
     */
    private $listName;

    /**
     * @var string|null Sent message GUID. Exists only if returnGuid=true in request
     */
    private $messageGuid;

    /**
     * @var BounceReason Reason
     */
    private $reason;

    /**
     * @var null|string Diagnostic code
     */
    private $diagnosticCode;

    /**
     * Constructor.
     *
     * @param string $email Email
     * @param \DateTime $date Complain date
     * @param BounceReason $reason Reason
     * @param null|string $diagnosticCode Diagnostic code
     * @param int|null $listId List ID
     * @param string|null $listName List name
     * @param null|string $messageGuid Sent message GUID
     */
    public function __construct(
        $email,
        \DateTime $date,
        BounceReason $reason,
        ?string $diagnosticCode,
        ?int $listId,
        ?string $listName,
        ?string $messageGuid
    ) {
        parent::__construct($email, $date);
        $this->listId = $listId;
        $this->listName = $listName;
        $this->messageGuid = $messageGuid;
        $this->reason = $reason;
        $this->diagnosticCode = $diagnosticCode;
    }

    /**
     * Get list ID
     *
     * Exists only if with extended column set in request
     *
     * @return int|null List ID
     */
    public function getListId(): ?int
    {
        return $this->listId;
    }

    /**
     * Get list name
     *
     * Exists only if with extended column set in request
     *
     * @return null|string List name
     */
    public function getListName(): ?string
    {
        return $this->listName;
    }

    /**
     * Get sent message GUID
     *
     * Exists only if returnGuid=true in request
     *
     * @return null|string Sent message GUID
     */
    public function getMessageGuid(): ?string
    {
        return $this->messageGuid;
    }

    /**
     * Get reason
     *
     * @return BounceReason Reason
     */
    public function getReason(): BounceReason
    {
        return $this->reason;
    }

    /**
     * Get diagnostic code
     *
     * @return null|string Diagnostic code
     */
    public function getDiagnosticCode(): ?string
    {
        return $this->diagnosticCode;
    }
}
