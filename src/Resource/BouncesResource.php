<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Resource;

use Citilink\ExpertSenderApi\AbstractResource;
use Citilink\ExpertSenderApi\Enum\BouncesGetRequest\BounceType;
use Citilink\ExpertSenderApi\Request\BouncesGetRequest;
use Citilink\ExpertSenderApi\Response\BouncesGetResponse;

/**
 * Bounces resource
 *
 * @deprecated use {@see ExpertSenderApi} instead
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class BouncesResource extends AbstractResource
{
    /**
     * Get bounces data
     *
     * @param \DateTime $startDate Start date
     * @param \DateTime $endDate End date
     * @param BounceType|null $bounceType Bounce type
     *
     * @deprecated use {@see ExpertSenderApi::getBouncesList} instead
     *
     * @return BouncesGetResponse Bounces data
     */
    public function get(
        \DateTime $startDate,
        \DateTime $endDate,
        BounceType $bounceType = null
    ): BouncesGetResponse {
        return new BouncesGetResponse(
            $this->requestSender->send(new BouncesGetRequest($startDate, $endDate, $bounceType))
        );
    }
}
