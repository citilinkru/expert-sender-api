<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Response\ActivitiesGetResponse;

use Citilink\ExpertSenderApi\Exception\TryToAccessDataFromErrorResponseException;
use Citilink\ExpertSenderApi\Model\ActivitiesGetResponse\ClickActivity;
use Citilink\ExpertSenderApi\SpecificCsvMethodResponse;

/**
 * Response with clicks activity
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class ClicksActivityGetResponse extends SpecificCsvMethodResponse
{
    /**
     * Get open activities
     *
     * @return ClickActivity[]|iterable Open activities
     */
    public function getClicks(): iterable
    {
        if (!$this->isOk()) {
            throw new TryToAccessDataFromErrorResponseException($this);
        }

        foreach ($this->getCsvReader()->fetchAll() as $row) {
            yield new ClickActivity(
                $row['Email'],
                new \DateTime($row['Date']),
                intval($row['MessageId']),
                $row['MessageSubject'],
                $row['Url'],
                $row['Title'],
                isset($row['ListId']) ? intval($row['ListId']) : null,
                $row['ListName'] ?? null,
                $row['MessageGuid'] ?? null
            );
        }
    }
}
