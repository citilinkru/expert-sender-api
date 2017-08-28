<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Response\ActivitiesGetResponse;

use Citilink\ExpertSenderApi\Exception\TryToAccessDataFromErrorResponseException;
use Citilink\ExpertSenderApi\Model\ActivitiesGetResponse\SubscriptionActivity;
use Citilink\ExpertSenderApi\SpecificCsvMethodResponse;

/**
 * Response with subscription activities
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class SubscriptionsActivityGetResponse extends SpecificCsvMethodResponse
{
    /**
     * Get subscriptions
     *
     * @return SubscriptionActivity[]|iterable Subscriptions
     */
    public function getSubscriptions(): iterable
    {
        if (!$this->isOk()) {
            throw new TryToAccessDataFromErrorResponseException($this);
        }

        foreach ($this->getCsvReader()->fetchAll() as $row) {
            yield new SubscriptionActivity(
                $row['Email'],
                new \DateTime($row['Date']),
                intval($row['ListId']),
                $row['ListName']
            );
        }
    }
}
