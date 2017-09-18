<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Enum\SummaryStatisticsGetRequest;

use MyCLabs\Enum\Enum;

/**
 * Message type
 *
 * @method static MessageType NEWSLETTER()
 * @method static MessageType AUTORESPONDER()
 * @method static MessageType TRIGGER()
 * @method static MessageType TRANSACTIONAL()
 * @method static MessageType CONFIRMATION()
 * @method static MessageType RECURRING()
 * @method static MessageType TEST()
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
final class MessageType extends Enum
{
    /**
     * Newsletter
     */
    const NEWSLETTER = 'Newsletter';

    /**
     * Autoresponder
     */
    const AUTORESPONDER = 'Autoresponder';

    /**
     * Trigger
     */
    const TRIGGER = 'Trigger';

    /**
     * Transactional
     */
    const TRANSACTIONAL = 'Transactional';

    /**
     * Confirmation
     */
    const CONFIRMATION = 'Confirmation';

    /**
     * Recurring
     */
    const RECURRING = 'Recurring';

    /**
     * Test
     */
    const TEST = 'Test';
}
