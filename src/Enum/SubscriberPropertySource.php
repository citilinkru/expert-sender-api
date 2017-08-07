<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Enum;

use MyCLabs\Enum\Enum;

/**
 * Source of subscriber's property
 *
 * @method static SubscriberPropertySource WEB()
 * @method static SubscriberPropertySource PANEL()
 * @method static SubscriberPropertySource IMPORT()
 * @method static SubscriberPropertySource API()
 * @method static SubscriberPropertySource PREF_CENTER()
 * @method static SubscriberPropertySource NOT_SET()
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
final class SubscriberPropertySource extends Enum
{
    /**
     * Property was added/modified using a subscription webform
     */
    const WEB = 'Web';

    /**
     * Property was added/modified manually by user in ExpertSender application
     */
    const PANEL = 'Panel';

    /**
     * Property was added/modified during an import
     */
    const IMPORT = 'Import';

    /**
     * Property was added/modified using ExpertSender REST API
     */
    const API = 'Api';

    /**
     * Subscriber added/modified the property on Preference Center page
     */
    const PREF_CENTER = 'PrefCenter';

    /**
     * Source not set
     */
    const NOT_SET = 'NotSet';
}
