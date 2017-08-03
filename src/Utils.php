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

    /**
     * Convert boolean string equivalent to boolean value
     *
     * @param string $boolStringEquivalent Equivalent of boolean value from API
     *
     * @return bool Boolean value
     */
    public static function convertStringBooleanEquivalentToBool(string $boolStringEquivalent): bool
    {
        return $boolStringEquivalent === 'true';
    }
}
