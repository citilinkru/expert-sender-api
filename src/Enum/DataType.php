<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Enum;

use MyCLabs\Enum\Enum;

/**
 * Data type
 *
 * @method static DataType BOOLEAN()
 * @method static DataType STRING()
 * @method static DataType INTEGER()
 * @method static DataType DATE()
 * @method static DataType DATETIME()
 * @method static DataType DOUBLE()
 * @method static DataType DECIMAL()
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
final class DataType extends Enum
{
    /**
     * Boolean
     */
    const BOOLEAN = 'boolean';

    /**
     * Double
     */
    const DOUBLE = 'double';

    /**
     * String
     */
    const STRING = 'string';

    /**
     * Integer
     */
    const INTEGER = 'int';

    /**
     * Date
     */
    const DATE = 'date';

    /**
     * DateTime
     */
    const DATETIME = 'dateTime';

    /**
     * Decimal
     */
    const DECIMAL = 'decimal';
}
