<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Model\DataTablesGetTablesSummaryResponse;

/**
 * Details about table
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class TableDetails extends AbstractTableData
{
    /**
     * @var string Description
     */
    private $description;

    /**
     * @var TableColumnData[]|iterable Columns
     */
    private $columns;

    /**
     * Constructor.
     *
     * @param int $id ID
     * @param string $name Name
     * @param int $columnsCount Number of columns in table
     * @param int $relationshipsCount Number of relationships
     * @param int $relationshipsDestinationCount Number of relationships with other table
     * @param int $rowsCount Number of rows in table
     * @param string $description Description
     * @param TableColumnData[]|iterable $columns Columns
     */
    public function __construct(
        int $id,
        string $name,
        int $columnsCount,
        int $relationshipsCount,
        int $relationshipsDestinationCount,
        int $rowsCount,
        string $description,
        iterable $columns
    ) {
        parent::__construct($id, $name, $columnsCount, $relationshipsCount, $relationshipsDestinationCount, $rowsCount);
        $this->description = $description;
        $this->columns = $columns;
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

    /**
     * Get columns
     *
     * @return TableColumnData[]|iterable Columns
     */
    public function getColumns(): iterable
    {
        return $this->columns;
    }
}
