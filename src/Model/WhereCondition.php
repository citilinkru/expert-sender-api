<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Model;

use Citilink\ExpertSenderApi\Enum\DataTablesGetDataPostRequest\Operator;
use Webmozart\Assert\Assert;

/**
 * Where condition to filter data from tables
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class WhereCondition
{
    /**
     * @var string Column name
     */
    private $columnName;

    /**
     * @var Operator Operator
     */
    private $operator;

    /**
     * @var string Value
     */
    private $value;

    /**
     * Constructor
     *
     * @param string $columnName Column name
     * @param Operator $operator Operator
     * @param string|int|float $value Value
     */
    public function __construct(string $columnName, Operator $operator, $value)
    {
        Assert::scalar($value);
        Assert::notEmpty($columnName);
        Assert::notEmpty($value);
        $this->columnName = $columnName;
        $this->operator = $operator;
        $this->value = strval($value);
    }

    /**
     * Get column name
     *
     * @return string Column name
     */
    public function getColumnName(): string
    {
        return $this->columnName;
    }

    /**
     * Get operator
     *
     * @return Operator Operator
     */
    public function getOperator(): Operator
    {
        return $this->operator;
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
}
