<?php

namespace LinguaLeo\ExpertSender\Results;

use LinguaLeo\ExpertSender\ApiResult;
use LinguaLeo\ExpertSender\ExpertSenderException;

class UserIdResult extends ApiResult
{
    protected $id;

    public function __construct($response)
    {
        parent::__construct($response);

        $this->parseBody();
    }

    public function parseBody()
    {
        $body = $this->response->getBody();
        $xml = new \SimpleXMLElement($body);

        $idXml = $xml->xpath('/ApiResponse/Data/Id');
        if (!is_array($idXml) || count($idXml) == 0) {
            throw new ExpertSenderException("Can't get user id");
        }

        $this->id = (string)$idXml[0];
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }
}