<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Model\DataTablesAddMultipleRowsPostRequest;

use Webmozart\Assert\Assert;

/**
 * Column
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class Column
{
    /**
     * @var string Name
     */
    private $name;

    /**
     * @var string|null Value
     */
    private $value;

    /**
     * Constructor
     *
     * @param $name
     * @param int|float|string|null $value
     */
    public function __construct(string $name, $value)
    {
        Assert::nullOrScalar($value);
        Assert::notEmpty($name);
        $this->name = $name;
        $this->value = $value !== null ? strval($value) : null;
    }

    /**
     * Get name
     *
     * @return string Name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get value
     *
     * @return string|null Value
     */
    public function getValue(): ?string
    {
        return $this->value;
    }
}