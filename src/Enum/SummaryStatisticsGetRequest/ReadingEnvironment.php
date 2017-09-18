<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Enum\SummaryStatisticsGetRequest;

use MyCLabs\Enum\Enum;

/**
 * Reading environment
 *
 * @method static ReadingEnvironment OTHER()
 * @method static ReadingEnvironment DESKTOP()
 * @method static ReadingEnvironment MOBILE()
 * @method static ReadingEnvironment WEBMAIL()
 * @method static ReadingEnvironment NO_ACTIVITY()
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
final class ReadingEnvironment extends Enum
{
    /**
     * Other
     */
    const OTHER = 'Other';

    /**
     * Desktop
     */
    const DESKTOP = 'Desktop';

    /**
     * Mobile
     */
    const MOBILE = 'Mobile';

    /**
     * Webmail
     */
    const WEBMAIL = 'Webmail';

    /**
     * NoActivity
     */
    const NO_ACTIVITY = 'NoActivity';
}
