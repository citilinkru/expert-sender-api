<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Response;

use Citilink\ExpertSenderApi\Enum\SubscribersResponse\StateOnListStatus;
use Citilink\ExpertSenderApi\Exception\ParseResponseException;
use Citilink\ExpertSenderApi\Exception\TryToAccessDataFromErrorResponseException;
use Citilink\ExpertSenderApi\Model\SubscribersGetResponse\StateOnList;
use Citilink\ExpertSenderApi\SpecificMethodResponse;

/**
 * Short information about subscriber
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class SubscribersGetShortResponse extends SpecificMethodResponse
{
    /**
     * Is subscriber in black list (local or global)
     *
     * @return bool Is subscriber in black list (local or global)
     */
    public function isInBlackList()
    {
        if (!$this->isOk()) {
            throw TryToAccessDataFromErrorResponseException::createFromResponse($this);
        }

        $xml = $this->getSimpleXml();
        $nodes = $xml->xpath('/ApiResponse/Data/BlackList');
        if (count($nodes) === 0) {
            throw ParseResponseException::createFromResponse('Can\'t fine BlackList element' , $this);
        }

        return strval(reset($nodes)) === 'true';
    }

    /**
     * Get all state on list
     *
     * @return StateOnList[] States on list
     */
    public function getStateOnLists(): array
    {
        if (!$this->isOk()) {
            throw TryToAccessDataFromErrorResponseException::createFromResponse($this);
        }

        $xml = $this->getSimpleXml();
        $nodes = $xml->xpath('/ApiResponse/Data/StateOnLists/StateOnList');

        $array = [];
        foreach ($nodes as $node) {
            $array[] = new StateOnList(
                intval($node->ListId),
                strval($node->Name),
                new StateOnListStatus(strval($node->Status)),
                new \DateTime(strval($node->SubscriptionDate))
            );
        }

        return $array;
    }
}
