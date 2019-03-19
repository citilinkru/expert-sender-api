<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Request;

use Citilink\ExpertSenderApi\Enum\HttpMethod;
use Citilink\ExpertSenderApi\Model\Column;
use Citilink\ExpertSenderApi\RequestInterface;
use Citilink\ExpertSenderApi\Traits\ColumnToXmlConverterTrait;
use Webmozart\Assert\Assert;

/**
 * Request for POST /Api/DataTablesUpdateRow
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class DataTablesUpdateRowPostRequest implements RequestInterface
{
    use ColumnToXmlConverterTrait;

    /**
     * @var string Table name
     */
    private $tableName;

    /**
     * Primary key columns
     *
     * Collection of Column elements. Contains unique identifier (PK, primary key) of the row that is supposed to be
     * updated. This is an equivalent of SQL "WHERE" directive
     *
     * @var Column[]
     */
    private $primaryKeyColumns;

    /**
     * Columns to update
     *
     * Collection of Column elements. Contains information about columns that are supposed to be updated and their new
     * values. This is an equivalent of SQL "SET" directive
     *
     * @var Column[]
     */
    private $columns;

    /**
     * Constructor.
     *
     * @param string $tableName Table name
     * @param Column[] $primaryKeyColumns Primary key columns. Collection of Column elements. Contains unique
     *      identifier (PK, primary key) of the row that is supposed to be updated. This is an equivalent of
     *      SQL "WHERE" directive
     * @param Column[] $columns Columns. Collection of Column elements. Contains information about columns that are
     *      supposed to be updated and their new values. This is an equivalent of SQL "SET" directive
     */
    public function __construct($tableName, array $primaryKeyColumns, array $columns)
    {
        Assert::notEmpty($tableName);
        Assert::notEmpty($primaryKeyColumns);
        Assert::notEmpty($columns);
        $this->tableName = $tableName;
        $this->primaryKeyColumns = $primaryKeyColumns;
        $this->columns = $columns;
    }

    /**
     * {@inheritdoc}
     */
    public function toXml(): string
    {
        $xmlWriter = new \XMLWriter();
        $xmlWriter->openMemory();
        $xmlWriter->writeElement('TableName', $this->tableName);

        $xmlWriter->startElement('PrimaryKeyColumns');
        foreach ($this->primaryKeyColumns as $primaryKeyColumn) {
            $this->convertColumnToXml($primaryKeyColumn, $xmlWriter);
        }

        $xmlWriter->endElement(); // PrimaryKeyColumns

        $xmlWriter->startElement('Columns');
        foreach ($this->columns as $column) {
            $this->convertColumnToXml($column, $xmlWriter);
        }

        $xmlWriter->endElement(); // Columns

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
        return '/v2/Api/DataTablesUpdateRow';
    }
}
