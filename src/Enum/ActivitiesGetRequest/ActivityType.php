<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Enum\ActivitiesGetRequest;

use MyCLabs\Enum\Enum;

/**
 * Activity type of subscriber activity
 *
 * @method static ActivityType SUBSCRIPTIONS()
 * @method static ActivityType CONFIRMATIONS()
 * @method static ActivityType SENDS()
 * @method static ActivityType OPENS()
 * @method static ActivityType CLICKS()
 * @method static ActivityType COMPLAINTS()
 * @method static ActivityType REMOVALS()
 * @method static ActivityType BOUNCES()
 * @method static ActivityType GOALS()
 */
final class ActivityType extends Enum
{
    /**
     * New subscriptions to lists. That also include subscribers that were imported, added manually etc.
     */
    const SUBSCRIPTIONS = 'Subscriptions';

    /**
     * Subscription confirmations. This only applies to double opt-in lists.
     */
    const CONFIRMATIONS = 'Confirmations';

    /**
     * Sent messages to individual subscribers.
     *
     * A single subscriber can receive multiple messages and all those events will be included.
     */
    const SENDS = 'Sends';

    /**
     * Message opens.
     *
     * If a subscriber opens a message multiple times (the same or different message) all events will be included.
     */
    const OPENS = 'Opens';

    /**
     * Link clicks. Same as Opens.
     */
    const CLICKS = 'Clicks';

    /**
     * Spam complaints
     */
    const COMPLAINTS = 'Complaints';

    /**
     * Unsubscriptions and manual removal of subscribers from lists.
     */
    const REMOVALS = 'Removals';

    /**
     * Bounced messages.
     */
    const BOUNCES = 'Bounces';

    /**
     * Fulfilled business goals.
     */
    const GOALS = 'Goals';
}
