<?php
namespace LinguaLeo\ExpertSender\Entities;

use LinguaLeo\ExpertSender\ExpertSenderException;

class Receiver
{
    protected $email;
    protected $id;

    function __construct($email = null, $id = null)
    {
        if ($email == null && $id == null) {
            throw new ExpertSenderException("Email or id parameter required");
        }

        $this->email = $email;
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
}