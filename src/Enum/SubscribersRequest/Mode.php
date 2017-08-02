<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Enum\SubscribersRequest;

use MyCLabs\Enum\Enum;

/**
 * Adding mode
 *
 * @method static Mode ADD_AND_UPDATE()
 * @method static Mode ADD_AND_REPLACE()
 * @method static Mode ADD_AND_IGNORE()
 * @method static Mode IGNORE_AND_UPDATE()
 * @method static Mode IGNORE_AND_REPLACE()
 * @method static Mode SYNCHRONIZE()
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
final class Mode extends Enum
{
    /**
     * Add new subscribers and update custom fields of subscribers existing on the list
     */
    const ADD_AND_UPDATE = 'AddAndUpdate';

    /**
     * Add new subscribers and replace custom fields of subscribers existing on the list
     */
    const ADD_AND_REPLACE = 'AddAndReplace';

    /**
     * Add new subscribers and do not update or replace custom fields of subscribers existing on the list
     */
    const ADD_AND_IGNORE = 'AddAndIgnore';

    /**
     * Do not add new subscribers, only update custom fields of subscribers existing on the list
     */
    const IGNORE_AND_UPDATE = 'IgnoreAndUpdate';

    /**
     * Do not add new subscribers, only replace custom fields of subscribers existing on the list
     */
    const IGNORE_AND_REPLACE = 'IgnoreAndReplace';

    /**
     * Has add mod
     *
     * @return bool Has add method
     */
    public function isAddEnabled(): bool
    {
        return in_array($this->value, [self::ADD_AND_UPDATE, self::ADD_AND_IGNORE, self::ADD_AND_REPLACE]);
    }

    /**
     * Has edit mod
     *
     * @return bool Has edit mod
     */
    public function isEditEnabled(): bool
    {
        return in_array(
            $this->value,
            [self::IGNORE_AND_UPDATE, self::IGNORE_AND_REPLACE, self::ADD_AND_UPDATE, self::ADD_AND_REPLACE]
        );
    }
}
