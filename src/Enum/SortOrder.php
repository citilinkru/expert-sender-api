<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Enum;

use MyCLabs\Enum\Enum;

/**
 * Sort Order
 *
 * @method static SortOrder ASCENDING()
 * @method static SortOrder DESCENDING()
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
final class SortOrder extends Enum
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
