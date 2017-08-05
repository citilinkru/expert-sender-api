<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi;

use Citilink\ExpertSenderApi\Exception\NotValidXmlException;

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

    /**
     * Create SimpleXML from string
     *
     * @param string $string Xml string
     *
     * @throws NotValidXmlException If xml is not valid and can't create SimpleXML object
     *
     * @return \SimpleXMLElement SimpleXML
     */
    public static function createSimpleXml($string): \SimpleXMLElement
    {
        $oldValue = libxml_use_internal_errors(true);

        $simpleXml = simplexml_load_string($string);
        if ($simpleXml === false) {
            $errors = libxml_get_errors();
            libxml_use_internal_errors($oldValue);
            throw new NotValidXmlException(
                $errors,
                'Can\'t create SimpleXml object. Maybe content is empty, or contains non xml data'
            );
        }

        libxml_use_internal_errors($oldValue);

        return $simpleXml;
    }
}
