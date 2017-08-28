<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Response\ActivitiesGetResponse;

use Citilink\ExpertSenderApi\Enum\ActivitiesGetRequest\RemovalReason;
use Citilink\ExpertSenderApi\Exception\TryToAccessDataFromErrorResponseException;
use Citilink\ExpertSenderApi\Model\ActivitiesGetResponse\RemovalActivity;
use Citilink\ExpertSenderApi\SpecificCsvMethodResponse;

/**
 * Removals activity get response
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class RemovalsActivityGetResponse extends SpecificCsvMethodResponse
{
    /**
     * Get removal activities
     *
     * @return RemovalActivity[]|iterable Removal activities
     */
    public function getRemovals(): iterable
    {
        if (!$this->isOk()) {
            throw new TryToAccessDataFromErrorResponseException($this);
        }

        foreach ($this->getCsvReader()->fetchAll() as $row) {
            yield new RemovalActivity(
                $row['Email'],
                new \DateTime($row['Date']),
                intval($row['MessageId']),
                $row['MessageSubject'],
                new RemovalReason($row['Reason']),
                isset($row['ListId']) ? intval($row['ListId']) : null,
                $row['ListName'] ?? null,
                $row['MessageGuid'] ?? null
            );
        }
    }
}
