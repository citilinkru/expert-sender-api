<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Request;

use Citilink\ExpertSenderApi\Enum\HttpMethod;
use Citilink\ExpertSenderApi\RequestInterface;

/**
 * Request for delete subscriber
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class SubscribersDeleteRequest implements RequestInterface
{
    /**
     * @var string|null Subscriber email
     */
    private $email;

    /**
     * @var int|null Subscriber ID
     */
    private $id;

    /**
     * @var int|null List ID
     */
    private $listId;

    /**
     * Create request with ID as identifier
     *
     * @param int $id Subscriber ID
     * @param int|null $listId List ID
     *
     * @return static Request for delete subscriber
     */
    public static function createFromId(int $id, int $listId = null)
    {
        return new static(null, $id, $listId);
    }

    /**
     * Create request with email as identifier
     *
     * @param string $email Subscriber email
     * @param int|null $listId List ID
     *
     * @return static Request for delete subscriber
     */
    public static function createFromEmail(string $email, int $listId = null)
    {
        return new static($email, null, $listId);
    }

    /**
     * Constructor
     *
     * @param null|string $email Subscriber email
     * @param int|null $id Subscriber ID
     * @param int|null $listId List ID
     */
    private function __construct(string $email = null, int $id = null, int $listId = null)
    {
        $this->email = $email;
        $this->id = $id;
        $this->listId = $listId;
    }

    /**
     * {@inheritdoc}
     */
    public function toXml(): string
    {
        return '';
    }

    /**
     * {@inheritdoc}
     */
    public function getQueryParams(): array
    {
        $params = [];
        if (!empty($this->email)) {
            $params['email'] = $this->email;
        }

        if (!empty($this->id)) {
            $params['id'] = $this->id;
        }

        if (!empty($this->listId)) {
            $params['listId'] = $this->listId;
        }

        return $params;
    }

    /**
     * {@inheritdoc}
     */
    public function getMethod(): HttpMethod
    {
        return HttpMethod::DELETE();
    }

    /**
     * {@inheritdoc}
     */
    public function getUri(): string
    {
        return '/v2/Api/Subscribers';
    }
}
