<?php

namespace LinguaLeo\ExpertSender\Entities;

class OrderBy
{

    /** @var string */
    protected $columnName;
    /** @var string */
    protected $direction;

    /**
     * @param string $columnName
     * @param string $direction
     */
    public function __construct($columnName, $direction)
    {
        $this->columnName = $columnName;
        $this->direction = $direction;
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
    public function getDirection()
    {
        return $this->direction;
    }

} 