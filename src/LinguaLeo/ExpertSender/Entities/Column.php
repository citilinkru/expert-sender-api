<?php

namespace LinguaLeo\ExpertSender\Entities;

class Column
{

    /** @var string */
    protected $name;
    /** @var string */
    protected $value;

    /**
     * @param string $name
     * @param string $value
     */
    public function __construct($name, $value = null)
    {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function hasValue()
    {
        return $this->value !== null;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

} 