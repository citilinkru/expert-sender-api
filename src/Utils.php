<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi;

/**
 * Utils
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class Utils
{
    /**
     * Convert bool value to string equivalent for ExpertSender API
     *
     * @param bool $bool Value
     *
     * @return string String equivalent of bool value for ExpertSender API
     */
    public static function convertBoolToStringEquivalent(bool $bool): string
    {
        return $bool ? 'true' : 'false';
    }
}
