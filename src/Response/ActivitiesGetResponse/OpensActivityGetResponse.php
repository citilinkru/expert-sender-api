<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Response\ActivitiesGetResponse;

use Citilink\ExpertSenderApi\Exception\TryToAccessDataFromErrorResponseException;
use Citilink\ExpertSenderApi\Model\ActivitiesGetResponse\OpenActivity;
use Citilink\ExpertSenderApi\SpecificCsvMethodResponse;

/**
 * Response with opens activity
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class OpensActivityGetResponse extends SpecificCsvMethodResponse
{
    /**
     * Get open activities
     *
     * @return OpenActivity[]|iterable Open activities
     */
    public function getOpens(): iterable
    {
        if (!$this->isOk()) {
            throw new TryToAccessDataFromErrorResponseException($this);
        }

        foreach ($this->getCsvReader()->fetchAll() as $row) {
            yield new OpenActivity(
                $row['Email'],
                new \DateTime($row['Date']),
                intval($row['MessageId']),
                $row['MessageSubject'],
                isset($row['ListId']) ? intval($row['ListId']) : null,
                $row['ListName'] ?? null,
                $row['MessageGuid'] ?? null
            );
        }
    }
}
