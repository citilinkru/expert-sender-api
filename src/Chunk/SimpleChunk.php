<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Chunk;

use Citilink\ExpertSenderApi\ChunkInterface;
use Webmozart\Assert\Assert;

/**
 * Simple chunk
 *
 * @deprecated Do not use it, this class will be deleted soon
 */
class SimpleChunk implements ChunkInterface
{
    /**
     * @var string Name
     */
    protected $name;

    /**
     * @var string Value
     */
    protected $value;

    /**
     * Constructor
     *
     * @param string $name Name
     * @param bool $value Value
     *
     * @return static Simple chunk
     */
    public static function createBool(string $name, bool $value)
    {
        return new static($name, $value ? 'true' : 'false');
    }

    /**
     * Constructor
     *
     * @param string $name Name
     * @param string|int|float $value Value
     */
    public function __construct(string $name, $value)
    {
        Assert::notEmpty($name);
        $this->name = $name;
        $this->value = strval($value);
    }

    /**
     * @inheritdoc
     */
    public function toXml(): string
    {
        return '<' . $this->name . '>' . $this->value . '</' . $this->name . '>';
    }
} 
