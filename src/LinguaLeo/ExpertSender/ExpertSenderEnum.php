<?php
namespace LinguaLeo\ExpertSender;

class ExpertSenderEnum
{
    const TYPE_BOOLEAN = 'boolean';
    const TYPE_STRING = 'string';
    const TYPE_INTEGER = 'int';
    const TYPE_DATE = 'date';
    const TYPE_DATE_TIME = 'dateTime';

    const MODE_ADD_AND_UPDATE = 'AddAndUpdate';
    const MODE_ADD_AND_REPLACE = 'AddAndReplace';
    const MODE_ADD_AND_IGNORE = 'AddAndIgnore';
    const MODE_IGNORE_AND_UPDATE = 'IgnoreAndUpdate';
    const MODE_IGNORE_AND_REPLACE = 'IgnoreAndReplace';
}