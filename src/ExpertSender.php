<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi;

use Citilink\ExpertSenderApi\Chunk\ColumnChunk;
use Citilink\ExpertSenderApi\Chunk\ColumnsChunk;
use Citilink\ExpertSenderApi\Chunk\DataChunk;
use Citilink\ExpertSenderApi\Chunk\HeaderChunk;
use Citilink\ExpertSenderApi\Chunk\OrderByChunk;
use Citilink\ExpertSenderApi\Chunk\OrderByColumnsChunk;
use Citilink\ExpertSenderApi\Chunk\PrimaryKeyColumnsChunk;
use Citilink\ExpertSenderApi\Model\TransactionalRequest\Receiver;
use Citilink\ExpertSenderApi\Chunk\ReceiversChunk;
use Citilink\ExpertSenderApi\Chunk\SimpleChunk;
use Citilink\ExpertSenderApi\Chunk\WhereChunk;
use Citilink\ExpertSenderApi\Chunk\WhereConditionsChunk;
use Citilink\ExpertSenderApi\Response\TableDataResponse;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

/**
 * Old ExpertSender API
 *
 * @deprecated Do not use it, this class will be deleted soon. Use {@see ExpertSenderApi}
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class ExpertSender implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    protected $apiKey;

    /** @var HttpTransport */
    protected $transport;

    protected $endpointUrl;
    protected $triggerUrlPattern;
    protected $addTableRowUrl;
    protected $deleteTableRowUrl;
    protected $updateTableRowUrl;
    protected $getTableDataUrl;

    private $transactionalUrlPattern;

    /**
     * @param $endpointUrl - url without /Api
     * @param $apiKey
     * @param $transport
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct($endpointUrl, $apiKey, $transport = null, LoggerInterface $logger = null)
    {
        if ($endpointUrl[strlen($endpointUrl) - 1] != '/') {
            $endpointUrl .= '/';
        }

        if ($transport === null) {
            $transport = new HttpTransport();
        }

        $this->endpointUrl = $endpointUrl . 'Api/';
        $this->triggerUrlPattern = $this->endpointUrl . 'Triggers/%s';
        $this->transactionalUrlPattern = $this->endpointUrl . 'Transactionals/%s';
        $this->addTableRowUrl = $this->endpointUrl . 'DataTablesAddRow';
        $this->deleteTableRowUrl = $this->endpointUrl . 'DataTablesDeleteRow';
        $this->updateTableRowUrl = $this->endpointUrl . 'DataTablesUpdateRow';
        $this->getTableDataUrl = $this->endpointUrl . 'DataTablesGetData';
        $this->apiKey = $apiKey;
        $this->transport = $transport;
        $this->logger = $logger ?: new NullLogger();
    }

    /**
     * @param string $tableName
     * @param ColumnChunk[] $columns
     *
     * @return \Citilink\ExpertSenderApi\SpecificMethodResponse
     */
    public function addTableRow($tableName, array $columns)
    {
        $tableNameChunk = new SimpleChunk('TableName', $tableName);
        $columnChunks = [];
        foreach ($columns as $column) {
            $columnChunks[] = new ColumnChunk($column->getName(), $column->getValue());
        }
        $columnsChunk = new ColumnsChunk($columnChunks);
        $dataChunk = new DataChunk([$columnsChunk], null);
        $headerChunk = $this->getHeaderChunk([$tableNameChunk, $dataChunk]);

        $response = $this->transport->post($this->addTableRowUrl, $headerChunk->toXml());
        $apiResult = new SpecificMethodResponse($response);
        $this->logApiResult(__METHOD__, $apiResult);
        return $apiResult;
    }

    /**
     * @param $tableName
     * @param ColumnChunk[] $columns
     * @param WhereChunk[] $where
     * @param OrderByChunk[] $orderByList
     * @param mixed $limit
     *
     * @return \Citilink\ExpertSenderApi\Response\TableDataResponse
     */
    public function getTableData(
        $tableName,
        array $columns = [],
        array $where = [],
        array $orderByList = [],
        $limit = null
    ) {
        $tableNameChunk = new SimpleChunk('TableName', $tableName);
        $columnsChunks = $whereChunks = $orderByChunks = [];
        foreach ($columns as $column) {
            $columnsChunks[] = new ColumnChunk($column->getName(), $column->getValue());
        }
        foreach ($where as $condition) {
            $whereChunks[] = new WhereChunk(
                $condition->getColumnName(), $condition->getOperator(), $condition->getValue()
            );
        }
        foreach ($orderByList as $direction) {
            $orderByChunks[] = new OrderByChunk($direction->getColumnName(), $direction->getSortOrder());
        }
        $chunks = [$tableNameChunk];
        if ($columnsChunks) {
            $chunks[] = new ColumnsChunk($columnsChunks);
        }
        if ($whereChunks) {
            $chunks[] = new WhereConditionsChunk($whereChunks);
        }
        if ($orderByChunks) {
            $chunks[] = new OrderByColumnsChunk($orderByChunks);
        }
        if ($limit) {
            $chunks[] = new SimpleChunk('Limit', (int)$limit);
        }
        $headerChunk = $this->getHeaderChunk($chunks);

        $response = $this->transport->post($this->getTableDataUrl, $headerChunk->toXml());
        $apiResult = new TableDataResponse($response);
        $this->logApiResult(__METHOD__, $apiResult);
        return $apiResult;
    }

    /**
     * @param string $tableName
     * @param ColumnChunk[] $primaryKeyColumns
     * @param ColumnChunk[] $columns
     * @return SpecificMethodResponse
     */
    public function updateTableRow($tableName, array $primaryKeyColumns, array $columns)
    {
        $tableNameChunk = new SimpleChunk('TableName', $tableName);
        $primaryKeysColumnsChunks = $columnsChunks = [];
        foreach ($primaryKeyColumns as $column) {
            $primaryKeysColumnsChunks[] = new ColumnChunk($column->getName(), $column->getValue());
        }
        foreach ($columns as $column) {
            $columnsChunks[] = new ColumnChunk($column->getName(), $column->getValue());
        }
        $primaryKeyColumnsChunk = new PrimaryKeyColumnsChunk($primaryKeysColumnsChunks);
        $columnsChunk = new ColumnsChunk($columnsChunks);
        $headerChunk = $this->getHeaderChunk([$tableNameChunk, $primaryKeyColumnsChunk, $columnsChunk]);

        $response = $this->transport->post($this->updateTableRowUrl, $headerChunk->toXml());
        $apiResult = new SpecificMethodResponse($response);
        $this->logApiResult(__METHOD__, $apiResult);
        return $apiResult;
    }

    /**
     * @param string $tableName
     * @param ColumnChunk[] $primaryKeyColumns
     * @return \Citilink\ExpertSenderApi\SpecificMethodResponse
     */
    public function deleteTableRow($tableName, array $primaryKeyColumns)
    {
        $tableNameChunk = new SimpleChunk('TableName', $tableName);
        $primaryKeysColumnsChunks = [];
        foreach ($primaryKeyColumns as $column) {
            $primaryKeysColumnsChunks[] = new ColumnChunk($column->getName(), $column->getValue());
        }
        $primaryKeyColumnsChunk = new PrimaryKeyColumnsChunk($primaryKeysColumnsChunks);
        $headerChunk = $this->getHeaderChunk([$tableNameChunk, $primaryKeyColumnsChunk]);

        $response = $this->transport->post($this->deleteTableRowUrl, $headerChunk->toXml());
        $apiResult = new SpecificMethodResponse($response);
        $this->logApiResult(__METHOD__, $apiResult);
        return $apiResult;
    }

    /**
     * @param $triggerId
     * @param Receiver[] $receiverChunks
     *
     * @return \Citilink\ExpertSenderApi\SpecificMethodResponse
     */
    public function sendTrigger($triggerId, $receiverChunks)
    {
        $dataChunk = new DataChunk([new ReceiversChunk($receiverChunks)], 'TriggerReceivers');
        $headerChunk = $this->getHeaderChunk([$dataChunk]);

        $url = sprintf($this->triggerUrlPattern, $triggerId);
        $response = $this->transport->post($url, $headerChunk->toXml());

        $apiResult = new SpecificMethodResponse($response);
        $this->logApiResult(__METHOD__, $apiResult);
        return $apiResult;
    }

    /**
     * @param ChunkInterface[] $chunks Кусочки запроса
     *
     * @return HeaderChunk
     */
    protected function getHeaderChunk(array $chunks)
    {
        return new HeaderChunk($this->apiKey, [$chunks]);
    }

    /**
     * @param string $method
     * @param SpecificMethodResponse $result
     */
    protected function logApiResult($method, SpecificMethodResponse $result)
    {
        if ($result->isOk()) {
            return;
        }

        $this->logger->error(
            sprintf(
                'ES method "%s" error response: %s.',
                $method,
                json_encode((array)$result, JSON_UNESCAPED_UNICODE | JSON_FORCE_OBJECT)
            )
        );
    }
}
