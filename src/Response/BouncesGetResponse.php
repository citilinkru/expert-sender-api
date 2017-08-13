<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Response;

use Citilink\ExpertSenderApi\Enum\BouncesGetResponse\BounceType;
use Citilink\ExpertSenderApi\Model\BouncesGetResponse\Bounce;
use Citilink\ExpertSenderApi\SpecificCsvMethodResponse;

/**
 * Bounces data
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class BouncesGetResponse extends SpecificCsvMethodResponse
{
    /**
     * Get bounces
     *
     * @return Bounce[]|\Generator Bounces
     */
    public function getBounces(): \Generator
    {
        foreach ($this->getCsvReader()->fetchAll() as $row) {
            yield new Bounce(
                new \DateTime($row['Date']),
                $row['Email'],
                $row['BounceCode'],
                new BounceType($row['BounceType'])
            );
        }
    }
}
