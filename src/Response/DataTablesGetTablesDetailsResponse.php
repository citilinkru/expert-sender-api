<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Response;

use Citilink\ExpertSenderApi\Exception\TryToAccessDataFromErrorResponseException;
use Citilink\ExpertSenderApi\Model\DataTablesGetTablesSummaryResponse\TableColumnData;
use Citilink\ExpertSenderApi\Model\DataTablesGetTablesSummaryResponse\TableDetails;
use Citilink\ExpertSenderApi\SpecificXmlMethodResponse;
use Citilink\ExpertSenderApi\Utils;

/**
 * Response with details of table
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class DataTablesGetTablesDetailsResponse extends SpecificXmlMethodResponse
{
    /**
     * Get table details
     *
     * @return TableDetails Table details
     */
    public function getDetails(): TableDetails
    {
        if (!$this->isOk()) {
            throw TryToAccessDataFromErrorResponseException::createFromResponse($this);
        }

        $node = $this->getSimpleXml()->xpath('/ApiResponse/Details')[0];

        return new TableDetails(
            intval($node->Id),
            strval($node->Name),
            intval($node->ColumnsCount),
            intval($node->RelationshipsCount),
            intval($node->RelationshipsDestinationCount),
            intval($node->Rows),
            strval($node->Description),
            $this->getColumns()
        );
    }

    /**
     * Get columns
     *
     * @return TableColumnData[]|iterable Columns
     */
    private function getColumns(): iterable
    {
        $nodes = $this->getSimpleXml()->xpath('/ApiResponse/Details/Columns/TableColumn');
        foreach ($nodes as $node) {
            yield new TableColumnData(
                strval($node->Name),
                strval($node->ColumnType),
                intval($node->Length),
                isset($node->DefaultValue) ? strval($node->DefaultValue) : null,
                isset($node->IsPrimaryKey) ? Utils::convertStringBooleanEquivalentToBool(
                    strval($node->IsPrimaryKey)
                ) : false,
                isset($node->IsRequired) ? Utils::convertStringBooleanEquivalentToBool(
                    strval($node->IsRequired)
                ) : false
            );
        }
    }
}
