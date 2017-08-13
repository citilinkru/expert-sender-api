<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Enum\DataTablesGetDataPostRequest;

use MyCLabs\Enum\Enum;

/**
 * Comparison operator
 *
 * @method static Operator EQUAL()
 * @method static Operator GREATER()
 * @method static Operator LOWER()
 * @method static Operator LIKE()
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
final class Operator extends Enum
{
    /**
     * Equals
     *
     * Can't name it like "EQUALS", because class Enum already has "exists" method
     */
    const EQUAL = 'Equals';

    /**
     * Greater
     */
    const GREATER = 'Greater';

    /**
     * Lower
     */
    const LOWER = 'Lower';

    /**
     * Like
     */
    const LIKE = 'Like';
}
