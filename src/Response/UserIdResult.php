<?php

namespace Citilink\ExpertSenderApi\Response;

use Citilink\ExpertSenderApi\Exception\ExpertSenderApiException;
use Citilink\ExpertSenderApi\SpecificMethodResponse;

/**
 * @deprecated Do not use it, this class will be deleted soon.
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class UserIdResult extends SpecificMethodResponse
{
    protected $id;

    public function __construct($response)
    {
        parent::__construct($response);

        $this->parseBody();
    }

    public function parseBody()
    {
        $body = $this->response->getContent();
        $xml = new \SimpleXMLElement($body);

        $idXml = $xml->xpath('/ApiResponse/Data/Id');
        if (!is_array($idXml) || count($idXml) == 0) {
            throw new ExpertSenderApiException("Can't get user id");
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
