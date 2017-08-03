<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Model\SubscribersPostRequest;

use Webmozart\Assert\Assert;

/**
 * Property of subscriber
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class Property
{
    /**
     * @var int ID
     */
    protected $id;

    /**
     * @var Value Value
     */
    private $value;

    /**
     * Constructor
     *
     * @param int $id ID
     * @param Value $value Value
     */
    public function __construct(int $id, Value $value)
    {
        Assert::notEmpty($id);
        $this->id = $id;
        $this->value = $value;
    }

    /**
     * Get ID
     *
     * @return int ID
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get value
     *
     * @return Value Value
     */
    public function getValue(): Value
    {
        return $this->value;
    }
}
