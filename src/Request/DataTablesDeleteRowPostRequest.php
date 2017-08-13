<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Request;

use Citilink\ExpertSenderApi\Enum\HttpMethod;
use Citilink\ExpertSenderApi\Model\Column;
use Citilink\ExpertSenderApi\RequestInterface;
use Citilink\ExpertSenderApi\Traits\ColumnToXmlConverterTrait;
use Webmozart\Assert\Assert;

/**
 * Request for POST /Api/DataTablesDeleteRow
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class DataTablesDeleteRowPostRequest implements RequestInterface
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
     * deleted. This is an equivalent of SQL "WHERE" directive
     *
     * @var Column[]
     */
    private $primaryKeyColumns;

    /**
     * Constructor
     *
     * @param string $tableName Table name
     * @param Column[] $primaryKeyColumns Primary key columns. Collection of Column elements. Contains unique
     *      identifier (PK, primary key) of the row that is supposed to be deleted. This is an equivalent of SQL
     *      "WHERE" directive
     */
    public function __construct($tableName, array $primaryKeyColumns)
    {
        Assert::notEmpty($tableName);
        Assert::notEmpty($primaryKeyColumns);
        Assert::allIsInstanceOf($primaryKeyColumns, Column::class);
        $this->tableName = $tableName;
        $this->primaryKeyColumns = $primaryKeyColumns;
    }

    /**
     * @inheritdoc
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

        return $xmlWriter->flush();
    }

    /**
     * @inheritdoc
     */
    public function getQueryParams(): array
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function getMethod(): HttpMethod
    {
        return HttpMethod::POST();
    }

    /**
     * @inheritdoc
     */
    public function getUri(): string
    {
        return '/Api/DataTablesDeleteRow';
    }
}