<?php
namespace LinguaLeo\ExpertSender;

class ExpertSenderResponse
{
    protected $responseCode;
    protected $body;

    public function __construct($body, $responseCode)
    {
        $this->body = $body;
        $this->responseCode = $responseCode;
    }

    public function isOk()
    {
        return ($this->responseCode >= 200) && ($this->responseCode <= 299);
    }

    /**
     * @return int
     */
    public function getResponseCode()
    {
        return $this->responseCode;
    }

    public function getErrorMessage()
    {
        if (preg_match("~<Message>(.+)</Message>~", $this->body, $matches)) {
            return $matches[1];
        }

        return '';
    }
}