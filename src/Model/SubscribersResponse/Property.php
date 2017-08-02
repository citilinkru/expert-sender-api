<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Model\SubscribersResponse;

use Citilink\ExpertSenderApi\Enum\SubscribersResponse\Source;
use Citilink\ExpertSenderApi\Enum\SubscribersResponse\Type;
use Webmozart\Assert\Assert;

/**
 * Subscriber property
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class Property
{
    /**
     * @var int ID
     */
    private $id;

    /**
     * @var Type Property type
     */
    private $type;

    /**
     * @var string Friendly name
     */
    private $friendlyName;

    /**
     * @var string System name
     */
    private $name;

    /**
     * @var Source Source
     */
    private $source;

    /**
     * @var Value Value
     */
    private $value;

    /**
     * @var string Description
     */
    private $description;

    /**
     * Constructor
     *
     * @param int $id ID
     * @param Type $type Property type
     * @param string $friendlyName Friendly name
     * @param string $name System name
     * @param string $description Description
     * @param Source $source Source
     * @param Value $value Value
     */
    public function __construct(
        int $id,
        Type $type,
        string $friendlyName,
        string $name,
        string $description,
        Source $source,
        Value $value
    ) {
        Assert::notEmpty($id);
        Assert::notEmpty($friendlyName);
        Assert::notEmpty($name);
        $this->id = $id;
        $this->type = $type;
        $this->friendlyName = $friendlyName;
        $this->name = $name;
        $this->source = $source;
        $this->value = $value;
        $this->description = $description;
    }

    /**
     * Return ID
     *
     * @return int ID
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Return property type
     *
     * @return \Citilink\ExpertSenderApi\Enum\SubscribersResponse\Type Property type
     */
    public function getType(): Type
    {
        return $this->type;
    }

    /**
     * Return friendly name
     *
     * @return string Friendly name
     */
    public function getFriendlyName(): string
    {
        return $this->friendlyName;
    }

    /**
     * Return system name
     *
     * @return string System name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Return source
     *
     * @return Source Source
     */
    public function getSource(): Source
    {
        return $this->source;
    }

    /**
     * Return value
     *
     * @return Value Value
     */
    public function getValue(): Value
    {
        return $this->value;
    }

    /**
     * Return description
     *
     * @return string Description
     */
    public function getDescription(): string
    {
        return $this->description;
    }
}
