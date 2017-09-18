<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Enum\SummaryStatisticsGetRequest;

use MyCLabs\Enum\Enum;

/**
 * Scope type
 *
 * @method static ScopeType LIST()
 * @method static ScopeType DOMAIN()
 * @method static ScopeType DOMAIN_FAMILY()
 * @method static ScopeType MESSAGE_TYPE()
 * @method static ScopeType IP()
 * @method static ScopeType SEGMENT()
 * @method static ScopeType VENDOR()
 * @method static ScopeType TAG()
 * @method static ScopeType SEND_TIME_OPTIMIZATION()
 * @method static ScopeType TIME_TRAVEL_OPTIMIZATION()
 * @method static ScopeType READING_ENVIRONMENT()
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
final class ScopeType extends Enum
{
    /**
     * Only results for specific subscriber list
     */
    const LIST = 'List';

    /**
     * Only results for specific domain
     */
    const DOMAIN = 'Domain';

    /**
     * Only results for specific domain family
     */
    const DOMAIN_FAMILY = 'DomainFamily';

    /**
     * Only results for specific message type
     */
    const MESSAGE_TYPE = 'MessageType';

    /**
     * Only results for specific IP channel
     */
    const IP = 'Ip';

    /**
     * Only results for specific subscriber segment
     */
    const SEGMENT = 'Segment';

    /**
     * Only results for specific vendor
     */
    const VENDOR = 'Vendor';

    /**
     * Only results for messages marked with a tag
     */
    const TAG = 'Tag';

    /**
     * Only results for messages with specific sending time optimization settings
     */
    const SEND_TIME_OPTIMIZATION = 'SendTimeOptimization';

    /**
     * Only results for messages with specific Time Travel settings
     */
    const TIME_TRAVEL_OPTIMIZATION = 'TimeTravelOptimization';

    /**
     * Only results for messages opened/clicked in specific reading environment
     */
    const READING_ENVIRONMENT = 'ReadingEnvironment';
}
