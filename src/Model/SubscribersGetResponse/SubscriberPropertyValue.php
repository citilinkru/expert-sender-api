<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Model\SubscribersGetResponse;

use Citilink\ExpertSenderApi\Enum\DataType;
use Citilink\ExpertSenderApi\Exception\InvalidUseOfClassException;

/**
 * Subscriber property value
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class SubscriberPropertyValue
{
    /**
     * @var int|null Integer value
     */
    private $intValue;

    /**
     * @var null|string String value
     */
    private $stringValue;

    /**
     * @var float|null Decimal value
     */
    private $decimalValue;

    /**
     * @var \DateTime|null Datetime value
     */
    private $datetimeValue;

    /**
     * @var int|null Default integer value
     */
    private $defaultIntValue;

    /**
     * @var null|string Default string value
     */
    private $defaultStringValue;

    /**
     * @var float|null Default decimal value
     */
    private $defaultDecimalValue;

    /**
     * @var \DateTime|null Default datetime value
     */
    private $defaultDatetimeValue;

    /**
     * @var DataType Data type
     */
    private $type;

    /**
     * Constructor
     *
     * @param int $intValue Integer value
     * @param int $defaultIntValue Integer value by default
     *
     * @return static Subscriber property value
     */
    public static function createInt(int $intValue, int $defaultIntValue)
    {
        return new static(DataType::INTEGER(), $intValue, $defaultIntValue, null);
    }

    /**
     * Constructor
     *
     * @param string $stringValue String value
     * @param string $defaultStringValue Default string value
     *
     * @return static Subscriber property value
     */
    public static function createString(string $stringValue, string $defaultStringValue)
    {
        return new static(
            DataType::STRING(), null, null, $stringValue, $defaultStringValue, null
        );
    }

    /**
     * Constructor
     *
     * @param float $decimalValue Decimal value
     * @param float $defaultDecimalValue Default decimal value
     *
     * @return static Subscriber property value
     */
    public static function createDecimal(float $decimalValue, float $defaultDecimalValue)
    {
        return new static(
            DataType::DECIMAL(),
            null,
            null,
            null,
            null,
            $decimalValue,
            $defaultDecimalValue
        );
    }

    /**
     * Constructor
     *
     * @param \DateTime $datetimeValue Datetime value
     * @param \DateTime $defaultDateTimeValue Default datetime value
     *
     * @return static Subscriber property value
     */
    public static function createDatetime(\DateTime $datetimeValue, \DateTime $defaultDateTimeValue)
    {
        return new static(
            DataType::DATETIME(),
            null,
            null,
            null,
            null,
            null,
            null,
            $datetimeValue,
            $defaultDateTimeValue
        );
    }

    /**
     * Constructor.
     *
     * @param DataType $type Data type
     * @param int|null $intValue Integer value
     * @param int|null $defaultIntValue Default integer value
     * @param string|null $stringValue String value
     * @param string|null $defaultStringValue Default string value
     * @param float|null $decimalValue Decimal value
     * @param float|null $defaultDecimalValue Default decimal value
     * @param \DateTime|null $datetimeValue Date value
     * @param \DateTime|null $defaultDateTimeValue Default date value
     */
    private function __construct(
        DataType $type,
        int $intValue = null,
        int $defaultIntValue = null,
        string $stringValue = null,
        string $defaultStringValue = null,
        float $decimalValue = null,
        float $defaultDecimalValue = null,
        \DateTime $datetimeValue = null,
        \DateTime $defaultDateTimeValue = null
    ) {
        $this->intValue = $intValue;
        $this->defaultIntValue = $defaultIntValue;
        $this->stringValue = $stringValue;
        $this->defaultStringValue = $defaultStringValue;
        $this->decimalValue = $decimalValue;
        $this->defaultDecimalValue = $defaultDecimalValue;
        $this->datetimeValue = $datetimeValue;
        $this->defaultDatetimeValue = $defaultDateTimeValue;
        $this->type = $type;
    }

    /**
     * Get integer value
     *
     * @throws InvalidUseOfClassException Wrong expected data type of value
     *
     * @return int Integer value
     */
    public function getIntValue(): int
    {
        if (!$this->type->equals(DataType::INTEGER())) {
            throw $this->createException(DataType::INTEGER());
        }

        if ($this->intValue === null) {
            throw InvalidUseOfClassException::createPropertyOfClassCanNotBeNull($this, 'intValue');
        }

        return $this->intValue;
    }

    /**
     * Get string value
     *
     * @throws InvalidUseOfClassException Wrong expected data type of value
     *
     * @return string String value
     */
    public function getStringValue(): string
    {
        if (!$this->type->equals(DataType::STRING())) {
            throw $this->createException(DataType::STRING());
        }

        if ($this->stringValue === null) {
            throw InvalidUseOfClassException::createPropertyOfClassCanNotBeNull($this, 'stringValue');
        }

        return $this->stringValue;
    }

    /**
     * Get decimal value
     *
     * @throws InvalidUseOfClassException Wrong expected data type of value
     *
     * @return float Decimal value
     */
    public function getDecimalValue(): float
    {
        if (!$this->type->equals(DataType::DECIMAL())) {
            throw $this->createException(DataType::DECIMAL());
        }

        if ($this->decimalValue === null) {
            throw InvalidUseOfClassException::createPropertyOfClassCanNotBeNull($this, 'decimalValue');
        }

        return $this->decimalValue;
    }

    /**
     * Get datetime value
     *
     * @throws InvalidUseOfClassException Wrong expected data type of value
     *
     * @return \DateTime Datetime value
     */
    public function getDatetimeValue(): \DateTime
    {
        if (!$this->type->equals(DataType::DATETIME())) {
            throw $this->createException(DataType::DATETIME());
        }

        if ($this->datetimeValue === null) {
            throw InvalidUseOfClassException::createPropertyOfClassCanNotBeNull($this, 'datetimeValue');
        }

        return $this->datetimeValue;
    }

    /**
     * Get default integer value
     *
     * @throws InvalidUseOfClassException Wrong expected data type of value
     *
     * @return int Default integer value
     */
    public function getDefaultIntValue(): int
    {
        if (!$this->type->equals(DataType::INTEGER())) {
            throw $this->createException(DataType::INTEGER());
        }

        if ($this->defaultIntValue === null) {
            throw InvalidUseOfClassException::createPropertyOfClassCanNotBeNull($this, 'defaultIntValue');
        }

        return $this->defaultIntValue;
    }

    /**
     * Get default string value
     *
     * @throws InvalidUseOfClassException Wrong expected data type of value
     *
     * @return string Default string value
     */
    public function getDefaultStringValue(): string
    {
        if (!$this->type->equals(DataType::STRING())) {
            throw $this->createException(DataType::STRING());
        }

        if ($this->defaultStringValue === null) {
            throw InvalidUseOfClassException::createPropertyOfClassCanNotBeNull($this, 'defaultStringValue');
        }

        return $this->defaultStringValue;
    }

    /**
     * Get default decimal value
     *
     * @throws InvalidUseOfClassException Wrong expected data type of value
     *
     * @return float Default decimal value
     */
    public function getDefaultDecimalValue(): float
    {
        if (!$this->type->equals(DataType::DECIMAL())) {
            throw $this->createException(DataType::DECIMAL());
        }

        if ($this->defaultDecimalValue === null) {
            throw InvalidUseOfClassException::createPropertyOfClassCanNotBeNull($this, 'defaultDecimalValue');
        }

        return $this->defaultDecimalValue;
    }

    /**
     * Get default datetime value
     *
     * @throws InvalidUseOfClassException Wrong expected data type of value
     *
     * @return \DateTime Default datetime value
     */
    public function getDefaultDatetimeValue(): \DateTime
    {
        if (!$this->type->equals(DataType::DATETIME())) {
            throw $this->createException(DataType::DATETIME());
        }

        if ($this->defaultDatetimeValue === null) {
            throw InvalidUseOfClassException::createPropertyOfClassCanNotBeNull($this, 'defaultDatetimeValue');
        }

        return $this->defaultDatetimeValue;
    }

    /**
     * Create exception
     *
     * @param DataType $expectedType Expected type
     *
     * @return InvalidUseOfClassException Exception
     */
    private function createException(DataType $expectedType): InvalidUseOfClassException
    {
        return new InvalidUseOfClassException(
            sprintf(
                'Data type of value is not "%s", type is "%s"',
                $expectedType->getValue(),
                $this->type->getValue()
            )
        );
    }

    /**
     * @return DataType
     */
    public function getType(): DataType
    {
        return $this->type;
    }
}
