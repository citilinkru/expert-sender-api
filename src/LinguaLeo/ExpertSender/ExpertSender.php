<?php
namespace LinguaLeo\ExpertSender;

use LinguaLeo\ExpertSender\Chunks\ChunkInterface;
use LinguaLeo\ExpertSender\Chunks\ColumnChunk;
use LinguaLeo\ExpertSender\Chunks\ColumnsChunk;
use LinguaLeo\ExpertSender\Chunks\DataChunk;
use LinguaLeo\ExpertSender\Chunks\GroupChunk;
use LinguaLeo\ExpertSender\Chunks\HeaderChunk;
use LinguaLeo\ExpertSender\Chunks\OrderByChunk;
use LinguaLeo\ExpertSender\Chunks\OrderByColumnsChunk;
use LinguaLeo\ExpertSender\Chunks\PrimaryKeyColumnsChunk;
use LinguaLeo\ExpertSender\Chunks\PropertiesChunk;
use LinguaLeo\ExpertSender\Chunks\PropertyChunk;
use LinguaLeo\ExpertSender\Chunks\ReceiverChunk;
use LinguaLeo\ExpertSender\Chunks\ReceiversChunk;
use LinguaLeo\ExpertSender\Chunks\SimpleChunk;
use LinguaLeo\ExpertSender\Chunks\SnippetChunk;
use LinguaLeo\ExpertSender\Chunks\SnippetsChunk;
use LinguaLeo\ExpertSender\Chunks\WhereChunk;
use LinguaLeo\ExpertSender\Chunks\WhereConditionsChunk;
use LinguaLeo\ExpertSender\Entities\Column;
use LinguaLeo\ExpertSender\Results\TableDataResult;
use LinguaLeo\ExpertSender\Results\UserIdResult;
use Psr\Log\LoggerInterface;

class ExpertSender
{
    protected $apiKey;

    /** @var HttpTransport */
    protected $transport;
    /** @var LoggerInterface */
    protected $logger;

    protected $endpointUrl;
    protected $subscribersUrl;
    protected $triggerUrlPattern;
    protected $addTableRowUrl;
    protected $deleteTableRowUrl;
    protected $updateTableRowUrl;
    protected $getTableDataUrl;

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
        $this->subscribersUrl = $this->endpointUrl . 'Subscribers';
        $this->triggerUrlPattern = $this->endpointUrl . 'Triggers/%s';
        $this->transactionalUrlPattern = $this->endpointUrl . 'Transactionals/%s';
        $this->addTableRowUrl = $this->endpointUrl . 'DataTablesAddRow';
        $this->deleteTableRowUrl = $this->endpointUrl . 'DataTablesDeleteRow';
        $this->updateTableRowUrl = $this->endpointUrl . 'DataTablesUpdateRow';
        $this->getTableDataUrl = $this->endpointUrl . 'DataTablesGetData';
        $this->apiKey = $apiKey;
        $this->transport = $transport;
        $this->logger = $logger;
    }

    /**
     * @param $email
     * @param integer $listId
     * @param array $properties - each element must be instance of Property class
     * @param string|null $firstName
     * @param string|null $lastName
     * @param string $mode - see ExpertSenderEnum for available values
     * @param integer|null $id
     * @param string|null $ip
     * @return ApiResult
     */
    public function addUserToList($email, $listId, $properties, $firstName = null, $lastName = null, $mode = ExpertSenderEnum::MODE_ADD_AND_UPDATE, $id = null, $ip = null)
    {
        $dataChunk = new DataChunk('Subscriber');
        $dataChunk->addChunk(new SimpleChunk('Mode', $mode));
        $dataChunk->addChunk(new SimpleChunk('Email', $email));
        $dataChunk->addChunk(new SimpleChunk('ListId', $listId));

        if ($firstName !== null) {
            $dataChunk->addChunk(new SimpleChunk('Firstname', $firstName));
        }

        if ($lastName !== null) {
            $dataChunk->addChunk(new SimpleChunk('Lastname', $lastName));
        }

        if ($id !== null) {
            $dataChunk->addChunk(new SimpleChunk('Id', $id));
        }

        if ($ip !== null) {
            $dataChunk->addChunk(new SimpleChunk('Ip', $ip));
        }

        $propertiesChunks = new PropertiesChunk();

        foreach ($properties as $property) {
            $propertiesChunks->addChunk(new PropertyChunk($property));
        }

        $dataChunk->addChunk($propertiesChunks);

        $headerChunk = $this->getHeaderChunk($dataChunk);

        $response = $this->transport->post($this->subscribersUrl, $headerChunk->getText());

        $apiResult = new ApiResult($response);
        $this->logApiResult(__METHOD__, $apiResult);
        return $apiResult;
    }

    /**
     * @param $email
     * @param int $listId
     * @return ApiResult
     */
    public function deleteUser($email, $listId = null)
    {
        $data = $this->getBaseData();
        $data['email'] = $email;
        if ($listId != null) {
            $data['listId'] = $listId;
        }

        $response = $this->transport->delete($this->subscribersUrl, $data);

        $apiResult = new ApiResult($response);
        $this->logApiResult(__METHOD__, $apiResult);
        return $apiResult;
    }

    /**
     * @param $email
     * @return UserIdResult
     */
    public function getUserId($email)
    {
        $data = $this->getBaseData();
        $data['email'] = $email;
        $data['option'] = '3';

        $response = $this->transport->get($this->subscribersUrl, $data);

        $apiResult = new UserIdResult($response);
        $this->logApiResult(__METHOD__, $apiResult);
        return $apiResult;
    }

    /**
     * @param string $tableName
     * @param Column[] $columns
     * @return \LinguaLeo\ExpertSender\ApiResult
     */
    public function addTableRow($tableName, array $columns)
    {
        $tableNameChunk = new SimpleChunk('TableName', $tableName);
        $dataChunk = new DataChunk();
        $columnsChunks = [];
        foreach ($columns as $column) {
            $columnsChunks[] = new ColumnChunk($column);
        }
        $columnsChunk = new ColumnsChunk($columnsChunks);
        $dataChunk->addChunk($columnsChunk);
        $groupChunk = new GroupChunk([$tableNameChunk, $dataChunk]);
        $headerChunk = $this->getHeaderChunk($groupChunk);

        $response = $this->transport->post($this->addTableRowUrl, $headerChunk->getText());
        $apiResult = new ApiResult($response);
        $this->logApiResult(__METHOD__, $apiResult);
        return $apiResult;
    }

    /**
     * @param $tableName
     * @param array $columns
     * @param array $where
     * @param array $orderBy
     * @param mixed $limit
     * @return \LinguaLeo\ExpertSender\Results\TableDataResult
     */
    public function getTableData(
        $tableName,
        array $columns = [],
        array $where = [],
        array $orderBy = [],
        $limit = null
    ) {
        $tableNameChunk = new SimpleChunk('TableName', $tableName);
        $columnsChunks = $whereChunks = $orderByChunks = [];
        foreach ($columns as $column) {
            $columnsChunks[] = new ColumnChunk($column);
        }
        foreach ($where as $condition) {
            $whereChunks[] = new WhereChunk($condition);
        }
        foreach ($orderBy as $direction) {
            $orderByChunks[] = new OrderByChunk($direction);
        }
        $groupChunk = new GroupChunk([$tableNameChunk]);
        if ($columnsChunks) {
            $groupChunk->addChunk(new ColumnsChunk($columnsChunks));
        }
        if ($whereChunks) {
            $groupChunk->addChunk(new WhereConditionsChunk($whereChunks));
        }
        if ($orderByChunks) {
            $groupChunk->addChunk(new OrderByColumnsChunk($orderByChunks));
        }
        if ($limit) {
            $limitChunk = new SimpleChunk('Limit', (int)$limit);
            $groupChunk->addChunk($limitChunk);
        }
        $headerChunk = $this->getHeaderChunk($groupChunk);

        $response = $this->transport->post($this->getTableDataUrl, $headerChunk->getText());
        $apiResult = new TableDataResult($response);
        $this->logApiResult(__METHOD__, $apiResult);
        return $apiResult;
    }

    /**
     * @param string $tableName
     * @param array $primaryKeyColumns
     * @param array $columns
     * @return ApiResult
     */
    public function updateTableRow($tableName, array $primaryKeyColumns, array $columns)
    {
        $tableNameChunk = new SimpleChunk('TableName', $tableName);
        $primaryKeysColumnsChunks = $columnsChunks = [];
        foreach ($primaryKeyColumns as $column) {
            $primaryKeysColumnsChunks[] = new ColumnChunk($column);
        }
        foreach ($columns as $column) {
            $columnsChunks[] = new ColumnChunk($column);
        }
        $primaryKeyColumnsChunk = new PrimaryKeyColumnsChunk($primaryKeysColumnsChunks);
        $columnsChunk = new ColumnsChunk($columnsChunks);
        $groupChunk = new GroupChunk([$tableNameChunk, $primaryKeyColumnsChunk, $columnsChunk]);
        $headerChunk = $this->getHeaderChunk($groupChunk);

        $response = $this->transport->post($this->updateTableRowUrl, $headerChunk->getText());
        $apiResult = new ApiResult($response);
        $this->logApiResult(__METHOD__, $apiResult);
        return $apiResult;
    }

    /**
     * @param string $tableName
     * @param Column[] $primaryKeyColumns
     * @return \LinguaLeo\ExpertSender\ApiResult
     */
    public function deleteTableRow($tableName, array $primaryKeyColumns)
    {
        $tableNameChunk = new SimpleChunk('TableName', $tableName);
        $primaryKeysColumnsChunks = [];
        foreach ($primaryKeyColumns as $column) {
            $primaryKeysColumnsChunks[] = new ColumnChunk($column);
        }
        $primaryKeyColumnsChunk = new PrimaryKeyColumnsChunk($primaryKeysColumnsChunks);
        $groupChunk = new GroupChunk([$tableNameChunk, $primaryKeyColumnsChunk]);
        $headerChunk = $this->getHeaderChunk($groupChunk);

        $response = $this->transport->post($this->deleteTableRowUrl, $headerChunk->getText());
        $apiResult = new ApiResult($response);
        $this->logApiResult(__METHOD__, $apiResult);
        return $apiResult;
    }

    /**
     * @param $listId
     * @param $from
     * @param $to
     * @return ApiResult
     */
    public function changeEmail($listId, $from, $to)
    {
        $result = $this->getUserId($from);
        $apiResult = $this->addUserToList($to, $listId, [], null, null, ExpertSenderEnum::MODE_ADD_AND_UPDATE, $result->getId());
        $this->logApiResult(__METHOD__, $apiResult);
        return $apiResult;
    }

    /**
     * @param $triggerId
     * @param $receivers
     * @return \LinguaLeo\ExpertSender\ApiResult
     */
    public function sendTrigger($triggerId, $receivers)
    {
        $receiverChunks = [];
        foreach($receivers as $receiver) {
            $receiverChunks[] = new ReceiverChunk($receiver);
        }

        $receiversChunks = new ReceiversChunk($receiverChunks);
        $dataChunk = new DataChunk('TriggerReceivers');
        $dataChunk->addChunk($receiversChunks);
        $headerChunk = $this->getHeaderChunk($dataChunk);

        $url = sprintf($this->triggerUrlPattern, $triggerId);
        $response = $this->transport->post($url, $headerChunk->getText());

        $apiResult = new ApiResult($response);
        $this->logApiResult(__METHOD__, $apiResult);
        return $apiResult;
    }

    /**
     * @param $transactionId
     * @param $receiver
     * @param $snippets
     * @return \LinguaLeo\ExpertSender\ApiResult
     */
    public function sendTransactional($transactionId, $receiver, $snippets)
    {
        $snippetChunks = [];
        foreach($snippets as $snippet) {
            $snippetChunks[] = new SnippetChunk($snippet);
        }

        $receiverChunk = new ReceiverChunk($receiver);
        $snippetsChunks = new SnippetsChunk($snippetChunks);
        $dataChunk = new DataChunk();
        $dataChunk->addChunk($receiverChunk);
        $dataChunk->addChunk($snippetsChunks);
        $headerChunk = $this->getHeaderChunk($dataChunk);

        $url = sprintf($this->transactionalUrlPattern, $transactionId);
        $response = $this->transport->post($url, $headerChunk->getText());

        $apiResult = new ApiResult($response);
        $this->logApiResult(__METHOD__, $apiResult);
        return $apiResult;
    }

    /**
     * @param ChunkInterface $bodyChunk
     * @return HeaderChunk
     */
    protected function getHeaderChunk(ChunkInterface $bodyChunk)
    {
        return new HeaderChunk($this->apiKey, $bodyChunk);
    }

    /**
     * @return array
     */
    protected function getBaseData()
    {
        return ['apiKey' => $this->apiKey];
    }

    /**
     * @param string $method
     * @param ApiResult $result
     */
    protected function logApiResult($method, ApiResult $result)
    {
        if (!$this->logger || $result->isOk()) {
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
?>
