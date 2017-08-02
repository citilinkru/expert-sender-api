<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Enum\SubscribersRequest;

use MyCLabs\Enum\Enum;

/**
 * Option for get information about subscriber request
 *
 * This option changes response content
 *
 * @method static SubscribersGetOption SHORT()
 * @method static SubscribersGetOption LONG()
 * @method static SubscribersGetOption FULL()
 * @method static SubscribersGetOption EVENTS_HISTORY()
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
final class SubscribersGetOption extends Enum
{
    /**
     * Short
     *
     * * Email state on particular lists
     * * Is this mail on Global Black List or Local Black List
     */
    const SHORT = 'Short';

    /**
     * Long
     *
     * Email state on particular lists
     * * Is this mail on Global Black List
     * * Suppression lists email belongs to
     */
    const LONG = 'Long';

    /**
     * Full
     *
     * * Email state on particular lists
     * * Is this mail on Global Black List
     * * Suppression lists email belongs to
     * * Subscriber’s data:
     * * * First name
     * * * Last name
     * * * IP
     * * * Subscriber ID
     * * * Vendor
     * * * All Properties...
     */
    const FULL = 'Full';

    /**
     * Events history
     *
     * * Information about all events associated with subscriber, such as sending a message, clicks, opens etc
     * * This is the same information as can be seen in the panel's Subscriber details
     */
    const EVENTS_HISTORY = 'EventsHistory';
}
