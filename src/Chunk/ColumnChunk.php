<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Chunk;

use Citilink\ExpertSenderApi\ChunkInterface;
use Webmozart\Assert\Assert;

/**
 * Column
 *
 * @deprecated Do not use it, this class will be deleted soon
 */
class ColumnChunk implements ChunkInterface
{
    /**
     * @var string Name
     */
    private $name;

    /**
     * @var string|null Value
     */
    private $value;

    /**
     * Constructor
     *
     * @param string $name Name
     * @param string|null $value Value
     */
    public function __construct(string $name, string $value = null)
    {
        Assert::notEmpty($name);
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * @inheritdoc
     */
    public function toXml(): string
    {
        $xml = '<Column>';
        $xml .= '<Name>' . $this->name . '</Name>';
        if ($this->value !== null) {
            $xml .= '<Value>';
            $valueToConcat = $this->value;
            $isValueHasHtmlTags = $this->value != strip_tags($this->value);
            if ($isValueHasHtmlTags) {
                $valueToConcat = sprintf('<![CDATA[%s]]>', $this->value);
            }

            $xml .= $valueToConcat;
            $xml .= '</Value>';
        }

        $xml .= '</Column>';

        return $xml;
    }
}
