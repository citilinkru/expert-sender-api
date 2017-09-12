<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Response\ActivitiesGetResponse;

use Citilink\ExpertSenderApi\Exception\TryToAccessDataFromErrorResponseException;
use Citilink\ExpertSenderApi\Model\ActivitiesGetResponse\ConfirmationActivity;
use Citilink\ExpertSenderApi\SpecificCsvMethodResponse;

/**
 * Response with confirmation activities
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class ConfirmationsActivityGetResponse extends SpecificCsvMethodResponse
{
    /**
     * Get subscriptions
     *
     * @return ConfirmationActivity[]|iterable Subscriptions
     */
    public function getConfirmations(): iterable
    {
        if (!$this->isOk()) {
            throw new TryToAccessDataFromErrorResponseException($this);
        }

        foreach ($this->getCsvReader()->fetchAll() as $row) {
            yield new ConfirmationActivity(
                $row['Email'],
                new \DateTime($row['Date']),
                intval($row['ListId']),
                $row['ListName']
            );
        }
    }
}
