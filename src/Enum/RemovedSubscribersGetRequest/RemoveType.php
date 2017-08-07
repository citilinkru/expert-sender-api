<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Enum\RemovedSubscribersGetRequest;

use MyCLabs\Enum\Enum;

/**
 * Reason of removing subscriber
 *
 * @method static RemoveType OPT_OUT_LINK()
 * @method static RemoveType UI()
 * @method static RemoveType BOUNCE_LIMIT()
 * @method static RemoveType COMPLAINT()
 * @method static RemoveType USER_UNKNOWN()
 * @method static RemoveType API()
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class RemoveType extends Enum
{
    /**
     * Subscriber clicked unsubscribe link in email
     */
    const OPT_OUT_LINK = 'OptOutLink';

    /**
     * Removed manually using user interface (ExpertSender panel)
     */
    const UI = 'Ui';

    /**
     * Removed because limit of bounced messages was reached
     */
    const BOUNCE_LIMIT = 'BounceLimit';

    /**
     * Subscriber issued a spam complaint
     */
    const COMPLAINT = 'Complaint';

    /**
     * Removed because email server returned User Unknown bounce (email address does not exist)
     */
    const USER_UNKNOWN = 'UserUnknown';

    /**
     * Removed using API
     */
    const API = 'Api';
}
