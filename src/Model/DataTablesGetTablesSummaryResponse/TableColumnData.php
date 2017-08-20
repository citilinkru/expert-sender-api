<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Model\DataTablesGetTablesSummaryResponse;

/**
 * Table column data
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class TableColumnData
{
    /**
     * @var string Column name.
     */
    private $name;

    /**
     * @var string Type of column
     */
    private $columnType;

    /**
     * @var int Length for string type columns
     */
    private $length;

    /**
     * @var string|null Default value. Null if column does not have default value
     */
    private $defaultValue;

    /**
     * @var bool Is a part of primary key (PK)
     */
    private $isPrimaryKey;

    /**
     * @var bool Is required
     */
    private $isRequired;

    /**
     * Constructor.
     *
     * @param string $name Column name
     * @param string $columnType Type of column
     * @param int $length Length for string type columns
     * @param string $defaultValue Default value. Null if column does not have default value
     * @param bool $isPrimaryKey Is a part of primary key (PK)
     * @param bool $isRequired Is required
     */
    public function __construct(
        string $name,
        string $columnType,
        int $length = 0,
        string $defaultValue = null,
        bool $isPrimaryKey = false,
        bool $isRequired = false
    ) {
        $this->name = $name;
        $this->columnType = $columnType;
        $this->length = $length;
        $this->defaultValue = $defaultValue;
        $this->isPrimaryKey = $isPrimaryKey;
        $this->isRequired = $isRequired;
    }

    /**
     * Get column name
     *
     * @return string Column name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get type of column
     *
     * @return string Type of column
     */
    public function getColumnType(): string
    {
        return $this->columnType;
    }

    /**
     * Get length for string type columns
     *
     * @return int Length for string type columns
     */
    public function getLength(): int
    {
        return $this->length;
    }

    /**
     * Get default value
     *
     * @return null|string Default value. Null if column does not have default value
     */
    public function getDefaultValue(): ?string
    {
        return $this->defaultValue;
    }

    /**
     * Is a part of primary key (PK)
     *
     * @return bool Is a part of primary key (PK)
     */
    public function isPrimaryKey(): bool
    {
        return $this->isPrimaryKey;
    }

    /**
     * Is required
     *
     * @return bool Is required
     */
    public function isRequired(): bool
    {
        return $this->isRequired;
    }
}
