<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Enum\SubscribersResponse;

use MyCLabs\Enum\Enum;

/**
 * Subscriber property type
 *
 * @method static Type TEXT()
 * @method static Type NUMBER()
 * @method static Type MONEY()
 * @method static Type URL()
 * @method static Type DATE()
 * @method static Type DATETIME()
 * @method static Type SINGLE_SELECT()
 * @method static Type BOOLEAN()
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
final class Type extends Enum
{
    /**
     * Text (string) property
     */
    const TEXT = 'Text';

    /**
     * Whole number, e.g. '0' or '123'
     */
    const NUMBER = 'Number';

    /**
     * A number with two decimal places, e.g. '10.99'
     */
    const MONEY = 'Money';

    /**
     * Url
     */
    const URL = 'Url';

    /**
     * Date, e.g. '2011-01-01'
     */
    const DATE = 'Date';

    /**
     * Date and time information, e.g. '2011-01-01 12:00:00'
     */
    const DATETIME = 'Datetime';

    /**
     * An enumeration of predefined values with one selected value possible, e.g. 'option 1'
     */
    const SINGLE_SELECT = 'SingleSelect';

    /**
     * True/false value
     */
    const BOOLEAN = 'Boolean';
}
