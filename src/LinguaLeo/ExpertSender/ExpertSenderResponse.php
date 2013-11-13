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
        $errorCode = $this->getErrorCode();

        return
            ($this->responseCode >= 200) &&
            ($this->responseCode <= 299) &&
            ($errorCode >= 200) &&
            ($errorCode <= 299);
    }

    /**
     * @return int
     */
    public function getResponseCode()
    {
        return $this->responseCode;
    }

    /**
     * @return int
     */
    public function getErrorCode()
    {
        if (preg_match("~<Code>(.+)</Code>~", $this->body, $matches)) {
            return $matches[1];
        }

        return 200;
    }

    public function getErrorMessage()
    {
        if (preg_match("~<Message>(.+)</Message>~", $this->body, $matches)) {
            return $matches[1];
        }

        return '';
    }

    /**
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }
}