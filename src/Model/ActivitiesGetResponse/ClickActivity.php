<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Model\ActivitiesGetResponse;

/**
 * Click activity
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class ClickActivity extends AbstractActivity
{
    /**
     * @var int Identifier of sent message
     */
    private $messageId;

    /**
     * @var string Subject of sent message
     */
    private $messageSubject;

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
     * @var string URL of clicked link (or URL template if link was personalized)
     */
    private $url;

    /**
     * @var string Title of clicked link (if "title" attribute was present in HTML)
     */
    private $title;

    /**
     * Constructor.
     *
     * @param string $email Subscriber's email
     * @param \DateTime $date Click date
     * @param int $messageId Identifier of sent message
     * @param string $messageSubject Subject of sent message
     * @param string $url URL of clicked link (or URL template if link was personalized)
     * @param string $title Title of clicked link (if "title" attribute was present in HTML)
     * @param int|null $listId List ID
     * @param null|string $listName List name
     * @param null|string $messageGuid Sent message GUID
     */
    public function __construct(
        $email,
        \DateTime $date,
        int $messageId,
        string $messageSubject,
        string $url,
        string $title,
        ?int $listId,
        ?string $listName,
        ?string $messageGuid
    ) {
        parent::__construct($email, $date);
        $this->messageId = $messageId;
        $this->messageSubject = $messageSubject;
        $this->listId = $listId;
        $this->listName = $listName;
        $this->messageGuid = $messageGuid;
        $this->url = $url;
        $this->title = $title;
    }

    /**
     * Get identifier of sent message
     *
     * @return int Identifier of sent message
     */
    public function getMessageId(): int
    {
        return $this->messageId;
    }

    /**
     * Get subject of sent message
     *
     * @return string Subject of sent message
     */
    public function getMessageSubject(): string
    {
        return $this->messageSubject;
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
     * Get URL of clicked link (or URL template if link was personalized)
     *
     * @return string URL of clicked link (or URL template if link was personalized)
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Get title of clicked link (if "title" attribute was present in HTML)
     *
     * @return string Title of clicked link (if "title" attribute was present in HTML)
     */
    public function getTitle(): string
    {
        return $this->title;
    }
}
