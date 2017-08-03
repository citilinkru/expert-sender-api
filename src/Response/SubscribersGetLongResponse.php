<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Response;

use Citilink\ExpertSenderApi\Exception\TryToAccessDataFromErrorResponseException;

/**
 * Long information of subscriber
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class SubscribersGetLongResponse extends SubscribersGetShortResponse
{
    /**
     * Get stop-lists which contains subscriber
     *
     * @return array Stop-lists which contains subscriber [<suppresion-list-id> => '<suppresion-list-name>']
     */
    public function getSuppressionStopLists(): array
    {
        if (!$this->isOk()) {
            throw TryToAccessDataFromErrorResponseException::createFromResponse($this);
        }

        $xml = $this->getSimpleXml();
        $nodes = $xml->xpath('/ApiResponse/Data/EmailInSuppressionLists/SuppressionList');
        $suppressionLists = [];
        foreach ($nodes as $node) {
            $suppressionLists[intval($node->Id)] = strval($node->Name);
        }

        return $suppressionLists;
    }
}
