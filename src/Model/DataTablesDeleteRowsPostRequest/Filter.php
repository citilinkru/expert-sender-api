<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Model\DataTablesDeleteRowsPostRequest;

use Citilink\ExpertSenderApi\Enum\DataTablesDeleteRowsPostRequest\FilterOperator;
use Webmozart\Assert\Assert;

/**
 * Filter for delete many rows
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class Filter
{
    /**
     * @var string Name
     */
    private $name;

    /**
     * @var string Value
     */
    private $value;

    /**
     * @var FilterOperator Operator
     */
    private $operator;

    /**
     * Constructor.
     *
     * @param string $name Name
     * @param FilterOperator $operator Operator
     * @param int|string|float $value Value
     */
    public function __construct(string $name, FilterOperator $operator, $value)
    {
        Assert::notEmpty($name);
        Assert::scalar($value);
        $this->name = $name;
        $this->value = strval($value);
        $this->operator = $operator;
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
     * @return string Value
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Get operator
     *
     * @return FilterOperator Operator
     */
    public function getOperator(): FilterOperator
    {
        return $this->operator;
    }
}
