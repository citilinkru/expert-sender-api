<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Resource;

use Citilink\ExpertSenderApi\AbstractResource;
use Citilink\ExpertSenderApi\Model\DataTablesAddMultipleRowsPostRequest\Row;
use Citilink\ExpertSenderApi\Request\DataTablesAddMultipleRowsPostRequest;
use Citilink\ExpertSenderApi\ResponseInterface;

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
}