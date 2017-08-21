<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Model\DataTablesGetTablesSummaryResponse;

/**
 * Table data
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
abstract class AbstractTableData
{
    /**
     * @var int Number of relationships with other table
     */
    private $relationshipsDestinationCount;

    /**
     * @var int Number of rows in table
     */
    private $rowsCount;

    /**
     * @var int Number of relationships
     */
    private $relationshipsCount;

    /**
     * @var string Name
     */
    private $name;

    /**
     * @var int ID
     */
    private $id;

    /**
     * @var int Number of columns in table
     */
    private $columnsCount;

    /**
     * Constructor.
     *
     * @param int $id ID
     * @param string $name Name
     * @param int $columnsCount Number of columns in table
     * @param int $relationshipsCount Number of relationships
     * @param int $relationshipsDestinationCount Number of relationships with other table
     * @param int $rowsCount Number of rows in table
     */
    public function __construct(
        int $id,
        string $name,
        int $columnsCount,
        int $relationshipsCount,
        int $relationshipsDestinationCount,
        int $rowsCount
    ) {
        $this->id = $id;
        $this->name = $name;
        $this->columnsCount = $columnsCount;
        $this->relationshipsCount = $relationshipsCount;
        $this->relationshipsDestinationCount = $relationshipsDestinationCount;
        $this->rowsCount = $rowsCount;
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
     * Get name
     *
     * @return string Name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get number of columns in table
     *
     * @return int Number of columns in table
     */
    public function getColumnsCount(): int
    {
        return $this->columnsCount;
    }

    /**
     * Get number of relationships
     *
     * @return int Number of relationships
     */
    public function getRelationshipsCount(): int
    {
        return $this->relationshipsCount;
    }

    /**
     * Get number of relationships with other table
     *
     * @return int Number of relationships with other table
     */
    public function getRelationshipsDestinationCount(): int
    {
        return $this->relationshipsDestinationCount;
    }

    /**
     * Get number of rows in table
     *
     * @return int Number of rows in table
     */
    public function getRowsCount(): int
    {
        return $this->rowsCount;
    }
}
