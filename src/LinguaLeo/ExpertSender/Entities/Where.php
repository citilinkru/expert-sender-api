<?php

namespace LinguaLeo\ExpertSender\Entities;

class Where
{

    /** @var string */
    protected $columnName;
    /** @var string */
    protected $operator;
    /** @var string */
    protected $value;

    /**
     * @param string $columnName
     * @param string $operator
     * @param string $value
     */
    public function __construct($columnName, $operator, $value)
    {
        $this->columnName = $columnName;
        $this->operator = $operator;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getColumnName()
    {
        return $this->columnName;
    }

    /**
     * @return string
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

} 