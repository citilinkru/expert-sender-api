<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Model\SubscribersRequest;

use Citilink\ExpertSenderApi\Enum\DataType;

/**
 * Value of property
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class Value
{
    /**
     * @var string Value as string
     */
    private $value;

    /**
     * @var DataType Data type
     */
    private $type;

    /**
     * Create value with type {@see DataType::INTEGER}
     *
     * @param int $value Value
     *
     * @return static Value of subscriber property
     */
    public static function createInt(int $value)
    {
        return new static(strval($value), DataType::INTEGER());
    }

    /**
     * Create value with type {@see DataType::STRING}
     *
     * @param string $value Value
     *
     * @return static Value of subscriber property
     */
    public static function createString(string $value)
    {
        return new static($value, DataType::STRING());
    }

    /**
     * Create value with type {@see DataType::BOOLEAN}
     *
     * @param bool $value Value
     *
     * @return static Value of subscriber property
     */
    public static function createBoolean(bool $value)
    {
        return new static($value ? 'true' : 'false', DataType::BOOLEAN());
    }

    /**
     * Create value with type {@see DataType::DOUBLE}
     *
     * @param float $value Value
     *
     * @return static Value of subscriber property
     */
    public static function createDouble(float $value)
    {
        return new static(strval($value), DataType::DOUBLE());
    }

    /**
     * Create value with type {@see DataType::DATETIME}
     *
     * @param \DateTime $dateTime Value
     *
     * @return static Value of subscriber property
     */
    public static function createDateTimeFromDateTime(\DateTime $dateTime)
    {
        return new static($dateTime->format('Y-m-d\TH:i:s'), DataType::DATETIME());
    }

    /**
     * Create value with type {@see DataType::DATE}
     *
     * @param \DateTime $dateTime Value
     *
     * @return static Value of subscriber property
     */
    public static function createDateFromDateTime(\DateTime $dateTime)
    {
        return new static($dateTime->format('Y-m-d'), DataType::DATE());
    }

    /**
     * Constructor
     *
     * @param string $value Value
     * @param DataType $type Data type
     */
    private function __construct(string $value, DataType $type)
    {
        $this->value = $value;
        $this->type = $type;
    }

    /**
     * Return value as string
     *
     * @return string Value as string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * Return data type
     *
     * @return DataType Data type
     */
    public function getType(): DataType
    {
        return $this->type;
    }
}
