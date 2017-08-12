<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Chunk;

use Citilink\ExpertSenderApi\ChunkInterface;
use Citilink\ExpertSenderApi\Enum\Operator;

/**
 * Where chunk
 *
 * @deprecated Do not use it, this class will be deleted soon
 */
class WhereChunk implements ChunkInterface
{
    /**
     * Шаблон
     */
    const PATTERN = '<Where>%s</Where>';

    /**
     * @var string Column name
     */
    private $columnName;

    /**
     * @var Operator Operator
     */
    private $operator;

    /**
     * @var string Value
     */
    private $value;

    /**
     * Constructor
     *
     * @param string $columnName Column name
     * @param Operator $operator Operator
     * @param string|float|int $value Value
     *
     * @internal param Where $where
     */
    public function __construct($columnName, Operator $operator, $value)
    {
        $this->columnName = $columnName;
        $this->operator = $operator;
        $this->value = $value;
    }

    /**
     * @inheritdoc
     */
    public function toXml(): string
    {
        $text = [];
        $text[] = (new SimpleChunk('ColumnName', $this->columnName))->toXml();
        $text[] = (new SimpleChunk('Operator', $this->operator->getValue()))->toXml();
        $text[] = (new SimpleChunk('Value', strval($this->value)))->toXml();

        return sprintf('<Where>%s</Where>', implode(PHP_EOL, $text));
    }

} 
