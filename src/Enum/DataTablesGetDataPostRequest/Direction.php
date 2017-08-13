<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Enum\DataTablesGetDataPostRequest;

use MyCLabs\Enum\Enum;

/**
 * Sort Order
 *
 * @method static Direction ASCENDING()
 * @method static Direction DESCENDING()
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
final class Direction extends Enum
{
    /**
     * Ascending
     */
    const ASCENDING = 'Ascending';

    /**
     * Descending
     */
    const DESCENDING = 'Descending';
}
