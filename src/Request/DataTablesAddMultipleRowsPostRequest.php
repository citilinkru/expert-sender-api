<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Request;

use Citilink\ExpertSenderApi\Enum\HttpMethod;
use Citilink\ExpertSenderApi\Model\DataTablesAddMultipleRowsPostRequest\Row;
use Citilink\ExpertSenderApi\RequestInterface;

/**
 * Request for POST DataTablesAddMultipleRows
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class DataTablesAddMultipleRowsPostRequest implements RequestInterface
{
    /**
     * @var string Table name
     */
    private $tableName;

    /**
     * @var Row[]|iterable Rows
     */
    private $rows;

    /**
     * Constructor
     *
     * @param string $tableName Table name
     * @param Row[]|iterable $rows Rows
     */
    public function __construct($tableName, iterable $rows)
    {
        $this->tableName = $tableName;
        $this->rows = $rows;
    }

    /**
     * @inheritdoc
     */
    public function toXml(): string
    {
        $xmlWriter = new \XMLWriter();
        $xmlWriter->openMemory();
        $xmlWriter->writeElement('TableName', $this->tableName);
        $xmlWriter->startElement('Data');
        foreach ($this->rows as $row) {
            $xmlWriter->startElement('Row');
            $xmlWriter->startElement('Columns');
            foreach ($row->getColumns() as $column) {
                $xmlWriter->startElement('Column');
                $xmlWriter->writeElement('Name', $column->getName());
                $value = $column->getValue();
                if ($value === null) {
                    $xmlWriter->startElement('Value');
                    $xmlWriter->writeAttributeNS('xsi', 'nil', null, 'true');
                    $xmlWriter->endElement(); // Value
                } else {
                    $xmlWriter->writeElement('Value', $column->getValue());
                }

                $xmlWriter->endElement(); // Column
            }

            $xmlWriter->endElement(); // Columns
            $xmlWriter->endElement(); // Row
        }

        $xmlWriter->endElement(); // Data

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
        return '/Api/DataTablesAddMultipleRows';
    }
}