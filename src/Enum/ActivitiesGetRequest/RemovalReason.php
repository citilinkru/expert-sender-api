<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Enum\ActivitiesGetRequest;

use MyCLabs\Enum\Enum;

/**
 * Removal reason for Removal activity
 *
 * @method static RemovalReason SUBSCRIBER()
 * @method static RemovalReason USER()
 * @method static RemovalReason BOUNCE()
 * @method static RemovalReason SPAM()
 * @method static RemovalReason USER_UNKNOWN()
 * @method static RemovalReason API()
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
final class RemovalReason extends Enum
{
    /**
     * Subscriber has unsubscribed from link using an unsubscribe link or otherwise.
     */
    const SUBSCRIBER = 'Subscriber';

    /**
     * Subscriber was manually removed by user.
     */
    const USER = 'User';

    /**
     * Subscriber was automatically removed because of reaching bounce limit.
     */
    const BOUNCE = 'Bounce';

    /**
     * Subscriber was automatically removed after sending spam complaint.
     */
    const SPAM = 'Spam';

    /**
     * Subscriber was automatically removed because the email address does not exist (caused “user unknown” bounce).
     */
    const USER_UNKNOWN = 'UserUnknown';

    /**
     * Subscriber was removed using API.
     */
    const API = 'Api';
}
