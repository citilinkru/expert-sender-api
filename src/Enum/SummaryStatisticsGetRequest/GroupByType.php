<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Enum\SummaryStatisticsGetRequest;

use MyCLabs\Enum\Enum;

/**
 * Group by type
 *
 * @method static GroupByType DATE()
 * @method static GroupByType MONTH()
 * @method static GroupByType MESSAGE()
 * @method static GroupByType LIST()
 * @method static GroupByType DOMAIN()
 * @method static GroupByType DOMAIN_FAMILY()
 * @method static GroupByType MESSAGE_TYPE()
 * @method static GroupByType IP()
 * @method static GroupByType SEGMENT()
 * @method static GroupByType VENDOR()
 * @method static GroupByType TAG()
 * @method static GroupByType SEND_TIME_OPTIMIZATION()
 * @method static GroupByType TIME_TRAVEL_OPTIMIZATION()
 * @method static GroupByType READING_ENVIRONMENT()
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
final class GroupByType extends Enum
{
    /**
     * Date
     */
    const DATE = 'Date';

    /**
     * Month
     */
    const MONTH = 'Month';

    /**
     * Message
     */
    const MESSAGE = 'Message';

    /**
     * List
     */
    const LIST = 'List';

    /**
     * Domain
     */
    const DOMAIN = 'Domain';

    /**
     * Domain family
     */
    const DOMAIN_FAMILY = 'DomainFamily';

    /**
     * Message type
     */
    const MESSAGE_TYPE = 'MessageType';

    /**
     * Ip
     */
    const IP = 'Ip';

    /**
     * Segment
     */
    const SEGMENT = 'Segment';

    /**
     * Vendor
     */
    const VENDOR = 'Vendor';

    /**
     * Tag
     */
    const TAG = 'Tag';

    /**
     * Send time optimization
     */
    const SEND_TIME_OPTIMIZATION = 'SendTimeOptimization';

    /**
     * Time travel optimization
     */
    const TIME_TRAVEL_OPTIMIZATION = 'TimeTravelOptimization';

    /**
     * Reading environment
     */
    const READING_ENVIRONMENT = 'ReadingEnvironment';
}
