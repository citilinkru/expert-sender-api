<?php
namespace LinguaLeo\ExpertSender;

class ExpertSenderEnum
{
    const TYPE_BOOLEAN = 'boolean';
    const TYPE_STRING = 'string';
    const TYPE_INTEGER = 'int';
    const TYPE_DATE = 'date';
    const TYPE_DATE_TIME = 'dateTime';

    const OPERATOR_EQUALS = 'Equals';
    const OPERATOR_GREATER = 'Greater';
    const OPERATOR_LOWER = 'Lower';
    const OPERATOR_LIKE = 'Like';

    const ORDER_ASCENDING = 'Ascending';
    const ORDER_DESCENDING = 'Descending';

    const MODE_ADD_AND_UPDATE = 'AddAndUpdate';
    const MODE_ADD_AND_REPLACE = 'AddAndReplace';
    const MODE_ADD_AND_IGNORE = 'AddAndIgnore';
    const MODE_IGNORE_AND_UPDATE = 'IgnoreAndUpdate';
    const MODE_IGNORE_AND_REPLACE = 'IgnoreAndReplace';

    /**
     * @return array
     */
    public static function getTypes()
    {
        return [self::TYPE_BOOLEAN, self::TYPE_STRING, self::TYPE_INTEGER, self::TYPE_DATE, self::TYPE_DATE_TIME];
    }

    /**
     * @return array
     */
    public static function getOperators()
    {
        return [self::OPERATOR_EQUALS, self::OPERATOR_GREATER, self::OPERATOR_LOWER, self::OPERATOR_LIKE];
    }

    /**
     * @return array
     */
    public static function getOrders()
    {
        return [self::ORDER_ASCENDING, self::ORDER_DESCENDING];
    }

    /**
     * @return array
     */
    public static function getModes()
    {
        return [self::MODE_ADD_AND_UPDATE, self::MODE_ADD_AND_REPLACE, self::MODE_ADD_AND_IGNORE, self::MODE_IGNORE_AND_UPDATE, self::MODE_IGNORE_AND_REPLACE];
    }
}
