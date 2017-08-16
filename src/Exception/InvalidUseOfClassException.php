<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Exception;

/**
 * Exception when somehow someone break architecture of class
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class InvalidUseOfClassException extends ExpertSenderApiException
{
    /**
     * Create exception for case, when property can not be null
     *
     * @param object $object Object
     * @param string $propertyName Property name
     *
     * @return static  Exception when somehow someone break architecture of class
     */
    public static function createPropertyOfClassCanNotBeNull($object, $propertyName)
    {
        return new static(
            'Invalid use of class, ' . get_class($object) . '::$' . $propertyName . 'property can not be null'
        );
    }
}
