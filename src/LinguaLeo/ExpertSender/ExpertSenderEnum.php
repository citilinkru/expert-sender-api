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
}