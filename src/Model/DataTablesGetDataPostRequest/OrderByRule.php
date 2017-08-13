<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Model\DataTablesGetDataPostRequest;

use Citilink\ExpertSenderApi\Enum\DataTablesGetDataPostRequest\Direction;
use Webmozart\Assert\Assert;

/**
 * Order by rule to get table data
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class OrderByRule
{
    /**
     * @var string Column name
     */
    private $columnName;

    /**
     * @var Direction Direction
     */
    private $direction;

    /**
     * Constructor
     *
     * @param string $columnName Column name
     * @param Direction $direction Sort order
     */
    public function __construct(string $columnName, Direction $direction)
    {
        Assert::notEmpty($columnName);
        $this->columnName = $columnName;
        $this->direction = $direction;
    }

    /**
     * @return string
     */
    public function getColumnName(): string
    {
        return $this->columnName;
    }

    /**
     * @return Direction
     */
    public function getDirection(): Direction
    {
        return $this->direction;
    }
}
