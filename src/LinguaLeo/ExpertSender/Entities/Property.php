<?php

namespace LinguaLeo\ExpertSender\Entities;

class Property
{
    protected $id;
    protected $type;
    protected $value;

    function __construct($id, $type, $value)
    {
        $this->id = $id;
        $this->type = $type;
        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}