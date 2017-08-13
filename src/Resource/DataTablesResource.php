<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Resource;

use Citilink\ExpertSenderApi\AbstractResource;
use Citilink\ExpertSenderApi\Model\Column;
use Citilink\ExpertSenderApi\Model\DataTablesAddMultipleRowsPostRequest\Row;
use Citilink\ExpertSenderApi\Model\DataTablesGetDataPostRequest\OrderByRule;
use Citilink\ExpertSenderApi\Model\DataTablesGetDataPostRequest\WhereCondition;
use Citilink\ExpertSenderApi\Request\DataTablesAddMultipleRowsPostRequest;
use Citilink\ExpertSenderApi\Request\DataTablesGetDataPostRequest;
use Citilink\ExpertSenderApi\Request\DataTablesUpdateRowPostRequest;
use Citilink\ExpertSenderApi\ResponseInterface;
use Citilink\ExpertSenderApi\SpecificCsvMethodResponse;

/**
 * Data tables resource
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class DataTablesResource extends AbstractResource
{
    /**
     * Add rows to table
     *
     * @param string $tableName Table name
     * @param Row[]|iterable $rows Rows
     *
     * @return ResponseInterface Response
     */
    public function addRows(string $tableName, iterable $rows)
    {
        return $this->requestSender->send(new DataTablesAddMultipleRowsPostRequest($tableName, $rows));
    }

    /**
     * Get table rows
     *
     * @param string $tableName Table name
     * @param string[] $columnNames Column names
     * @param WhereCondition[] $whereConditions Where conditions
     * @param OrderByRule[] $orderByRules Order by rules
     * @param int $limit Limit
     *
     * @return SpecificCsvMethodResponse Response
     */
    public function getRows(
        string $tableName,
        array $columnNames = [],
        array $whereConditions = [],
        array $orderByRules = [],
        $limit = null
    ): SpecificCsvMethodResponse {
        return new SpecificCsvMethodResponse(
            $this->requestSender->send(
                new DataTablesGetDataPostRequest($tableName, $columnNames, $whereConditions, $orderByRules, $limit)
            )
        );
    }

    /**
     * Update rows
     *
     * @param string $tableName Table name
     * @param Column[] $primaryKeyColumns Primary key columns. Collection of Column elements. Contains unique
     *      identifier (PK, primary key) of the row that is supposed to be updated. This is an equivalent of
     *      SQL "WHERE" directive
     * @param Column[] $columns Columns. Collection of Column elements. Contains information about columns that are
     *      supposed to be updated and their new values. This is an equivalent of SQL "SET" directive
     *
     * @return ResponseInterface Response
     */
    public function updateRows($tableName, array $primaryKeyColumns, array $columns): ResponseInterface
    {
        return $this->requestSender->send(new DataTablesUpdateRowPostRequest($tableName, $primaryKeyColumns, $columns));
    }
}