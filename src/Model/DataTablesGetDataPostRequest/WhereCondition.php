<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Model\DataTablesGetDataPostRequest;

use Citilink\ExpertSenderApi\Enum\DataTablesGetDataPostRequest\Operator;

/**
 * Where condition
 *
 * @deprecated Use {@see \Citilink\ExpertSenderApi\Model\WhereCondition} instead
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class WhereCondition extends \Citilink\ExpertSenderApi\Model\WhereCondition
{
    /**
     * Constructor.
     *
     * @param string $columnName Column name
     * @param Operator $operator Operator
     * @param float|int|string $value Value
     */
    public function __construct($columnName, Operator $operator, $value)
    {
        @trigger_error('use \Citilink\ExpertSenderApi\Model\WhereCondition instead', E_USER_DEPRECATED);

        parent::__construct($columnName, $operator, $value);
    }
}
