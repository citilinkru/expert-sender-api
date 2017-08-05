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
        foreach ($this->getCsvLinesWithoutHeader() as $value) {
            yield new Bounce(
                new \DateTime($value[0]),
                $value[1],
                $value[2],
                new BounceType($value[3])
            );
        }
    }
}
