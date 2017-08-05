<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Enum\BouncesGetResponse;

use MyCLabs\Enum\Enum;

/**
 * Bounce type
 *
 * @method static BounceType USER_UNKNOWN()
 * @method static BounceType MAILBOX_FULL()
 * @method static BounceType BLOCKED()
 * @method static BounceType UNKNOWN()
 * @method static BounceType OTHER()
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class BounceType extends Enum
{
    /**
     * Email does not exist
     */
    const USER_UNKNOWN = 'UserUnknown';

    /**
     * Mailbox is full or otherwise temporary inaccessible
     */
    const MAILBOX_FULL = 'MailboxFull';

    /**
     * Message blocked, usually for spam-related reasons
     */
    const BLOCKED = 'Blocked';

    /**
     * Unknown reason when bounce cannot be classified
     */
    const UNKNOWN = 'Unknown';

    /**
     * Other bounce reason. This category contains transport-related issues, mail server bugs etc
     */
    const OTHER = 'Other';
}
