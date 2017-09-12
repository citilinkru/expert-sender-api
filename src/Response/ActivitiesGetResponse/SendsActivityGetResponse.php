<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Response\ActivitiesGetResponse;

use Citilink\ExpertSenderApi\Exception\TryToAccessDataFromErrorResponseException;
use Citilink\ExpertSenderApi\Model\ActivitiesGetResponse\SendActivity;
use Citilink\ExpertSenderApi\SpecificCsvMethodResponse;

/**
 * Response with sends activity
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class SendsActivityGetResponse extends SpecificCsvMethodResponse
{
    /**
     * Get send activities
     *
     * @return SendActivity[]|iterable Send activities
     */
    public function getSends(): iterable
    {
        if (!$this->isOk()) {
            throw new TryToAccessDataFromErrorResponseException($this);
        }

        foreach ($this->getCsvReader()->fetchAll() as $row) {
            yield new SendActivity(
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
