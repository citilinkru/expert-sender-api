<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Model\TransactionalPostRequest;

use Webmozart\Assert\Assert;

/**
 * Snippet
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class Snippet
{
    /**
     * @var string Name
     */
    private $name;

    /**
     * @var string Value
     */
    private $value;

    /**
     * Constructor.
     *
     * @param string $name Name
     * @param string|int|float $value Value
     */
    public function __construct(string $name, $value)
    {
        Assert::notEmpty($name);
        Assert::scalar($value);
        $this->name = $name;
        $this->value = strval($value);
    }

    /**
     * Get name
     *
     * @return string Name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get value
     *
     * @return string Value
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
