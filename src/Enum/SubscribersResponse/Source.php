<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Enum\SubscribersResponse;

use MyCLabs\Enum\Enum;

/**
 * Source of subscriber's property
 *
 * @method static Source WEB()
 * @method static Source PANEL()
 * @method static Source IMPORT()
 * @method static Source API()
 * @method static Source PREF_CENTER()
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
final class Source extends Enum
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
}
