<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Response\ActivitiesGetResponse;

use Citilink\ExpertSenderApi\Exception\TryToAccessDataFromErrorResponseException;
use Citilink\ExpertSenderApi\Model\ActivitiesGetResponse\ComplaintActivity;
use Citilink\ExpertSenderApi\SpecificCsvMethodResponse;

/**
 * Complaint activity get response
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class ComplaintsActivityGetResponse extends SpecificCsvMethodResponse
{
    /**
     * Get complaint activities
     *
     * @return ComplaintActivity[]|iterable Complaint activities
     */
    public function getComplaints(): iterable
    {
        if (!$this->isOk()) {
            throw new TryToAccessDataFromErrorResponseException($this);
        }

        foreach ($this->getCsvReader()->fetchAll() as $row) {
            yield new ComplaintActivity(
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
