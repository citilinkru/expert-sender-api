<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Model\DataTablesGetTablesSummaryResponse;

/**
 * Table summary
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class TableSummary extends AbstractTableData
{
    /**
     * @var float Size of table in megabytes
     */
    private $size;

    /**
     * Constructor.
     *
     * @param int $id ID
     * @param string $name Name
     * @param int $columnsCount Number of columns in table
     * @param int $relationshipsCount Number of relationships
     * @param int $relationshipsDestinationCount Number of relationships with other table
     * @param int $rowsCount Number of rows in table
     * @param float $size Size of data in megabytes
     */
    public function __construct(
        int $id,
        string $name,
        int $columnsCount,
        int $relationshipsCount,
        int $relationshipsDestinationCount,
        int $rowsCount,
        float $size
    ) {
        parent::__construct(
            $id,
            $name,
            $columnsCount,
            $relationshipsCount,
            $relationshipsDestinationCount,
            $rowsCount
        );

        $this->size = $size;
    }

    /**
     * Get size of table in megabytes
     *
     * @return float Size of table in megabytes
     */
    public function getSize(): float
    {
        return $this->size;
    }
}
