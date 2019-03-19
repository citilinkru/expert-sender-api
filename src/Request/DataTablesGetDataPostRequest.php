<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Request;

use Citilink\ExpertSenderApi\Enum\HttpMethod;
use Citilink\ExpertSenderApi\Model\DataTablesGetDataPostRequest\OrderByRule;
use Citilink\ExpertSenderApi\Model\WhereCondition;
use Citilink\ExpertSenderApi\RequestInterface;
use Citilink\ExpertSenderApi\Traits\WhereConditionToXmlConverterTrait;

/**
 * Request for POST /Api/DataTablesGetData
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class DataTablesGetDataPostRequest implements RequestInterface
{
    use WhereConditionToXmlConverterTrait;

    /**
     * @var string Table name
     */
    private $tableName;

    /**
     * @var string[] Column names
     */
    private $columnNames = [];

    /**
     * @var WhereCondition[] Where conditions
     */
    private $whereConditions = [];

    /**
     * @var OrderByRule[] Order by rules
     */
    private $orderByRules = [];

    /**
     * @var int|null Limit
     */
    private $limit;

    /**
     * Constructor.
     *
     * @param string $tableName Table name
     * @param string[] $columnNames
     * @param WhereCondition[] $whereConditions Where conditions
     * @param OrderByRule[] $orderByRules Order by rules
     * @param int $limit Limit
     */
    public function __construct(
        string $tableName,
        array $columnNames = [],
        array $whereConditions = [],
        array $orderByRules = [],
        $limit = null
    ) {
        $this->tableName = $tableName;
        $this->columnNames = $columnNames;
        $this->whereConditions = $whereConditions;
        $this->orderByRules = $orderByRules;
        $this->limit = $limit;
    }

    /**
     * {@inheritdoc}
     */
    public function toXml(): string
    {
        $xmlWriter = new \XMLWriter();
        $xmlWriter->openMemory();
        $xmlWriter->writeElement('TableName', $this->tableName);
        if (!empty($this->columnNames)) {
            $xmlWriter->startElement('Columns');
            foreach ($this->columnNames as $column) {
                $xmlWriter->writeElement('Column', $column);
            }

            $xmlWriter->endElement(); // Columns
        }

        if (!empty($this->whereConditions)) {
            $xmlWriter->startElement('WhereConditions');
            foreach ($this->whereConditions as $whereCondition) {
                $this->convertWhereConditionToXml($whereCondition, $xmlWriter);
            }

            $xmlWriter->endElement(); // WhereConditions
        }

        if (!empty($this->orderByRules)) {
            $xmlWriter->startElement('OrderByColumns');
            foreach ($this->orderByRules as $orderByRule) {
                $xmlWriter->startElement('OrderBy');
                $xmlWriter->writeElement('ColumnName', $orderByRule->getColumnName());
                $xmlWriter->writeElement('Direction', $orderByRule->getDirection()->getValue());
                $xmlWriter->endElement(); // OrderBy
            }

            $xmlWriter->endElement(); // OrderByColumns
        }

        if ($this->limit !== null) {
            $xmlWriter->writeElement('Limit', strval($this->limit));
        }

        return $xmlWriter->flush();
    }

    /**
     * {@inheritdoc}
     */
    public function getQueryParams(): array
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getMethod(): HttpMethod
    {
        return HttpMethod::POST();
    }

    /**
     * {@inheritdoc}
     */
    public function getUri(): string
    {
        return '/v2/Api/DataTablesGetData';
    }
}
