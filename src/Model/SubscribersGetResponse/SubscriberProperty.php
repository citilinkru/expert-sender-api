<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Model\SubscribersGetResponse;

use Citilink\ExpertSenderApi\Enum\SubscriberPropertySource;
use Citilink\ExpertSenderApi\Enum\SubscribersResponse\SubscriberPropertyType;
use Webmozart\Assert\Assert;

/**
 * Subscriber property
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class SubscriberProperty
{
    /**
     * @var int ID
     */
    private $id;

    /**
     * @var SubscriberPropertyType Property type
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
     * @var SubscriberPropertySource Source
     */
    private $source;

    /**
     * @var SubscriberPropertyValue Value
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
     * @param SubscriberPropertyType $type Property type
     * @param string $friendlyName Friendly name
     * @param string $name System name
     * @param string $description Description
     * @param SubscriberPropertySource $source Source
     * @param SubscriberPropertyValue $value Value
     */
    public function __construct(
        int $id,
        SubscriberPropertyType $type,
        string $friendlyName,
        string $name,
        string $description,
        SubscriberPropertySource $source,
        SubscriberPropertyValue $value
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
     * Get ID
     *
     * @return int ID
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * Get property type
     *
     * @return SubscriberPropertyType Property type
     */
    public function getType(): SubscriberPropertyType
    {
        return $this->type;
    }

    /**
     * Get friendly name
     *
     * @return string Friendly name
     */
    public function getFriendlyName(): string
    {
        return $this->friendlyName;
    }

    /**
     * Get system name
     *
     * @return string System name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get source
     *
     * @return SubscriberPropertySource Source
     */
    public function getSource(): SubscriberPropertySource
    {
        return $this->source;
    }

    /**
     * Get value
     *
     * @return SubscriberPropertyValue Value
     */
    public function getValue(): SubscriberPropertyValue
    {
        return $this->value;
    }

    /**
     * Get description
     *
     * @return string Description
     */
    public function getDescription(): string
    {
        return $this->description;
    }
}
