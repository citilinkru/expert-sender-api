<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Enum\ActivitiesGetRequest;

use MyCLabs\Enum\Enum;

/**
 * Bounce reason of bounce activity
 *
 * @method static BounceReason USER_UNKNOWN()
 * @method static BounceReason MAILBOX_FULL()
 * @method static BounceReason BLOCKED()
 * @method static BounceReason OUT_OF_OFFICE()
 * @method static BounceReason UNKNOWN()
 * @method static BounceReason OTHER()
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class BounceReason extends Enum
{
    /**
     * Email does not exist.
     */
    const USER_UNKNOWN = 'UserUnknown';

    /**
     * Subscriber’s mailbox is full or otherwise temporary inaccessible.
     */
    const MAILBOX_FULL = 'MailboxFull';

    /**
     * Sent message was blocked, possibly for spam-related reasons.
     */
    const BLOCKED = 'Blocked';

    /**
     * Mailbox returned automated “out of office” reply.
     */
    const OUT_OF_OFFICE = 'OutOfOffice';

    /**
     * Unknown reason.
     */
    const UNKNOWN = 'Unknown';

    /**
     * Other bounce reason. This category contains transport-related issues, mail server bugs etc.
     */
    const OTHER = 'Other';
}
