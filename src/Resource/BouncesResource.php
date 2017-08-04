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
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class BouncesResource extends AbstractResource
{
    /**
     * @param \DateTime $startDate Start date
     * @param \DateTime $endDate End date
     * @param BounceType|null $bounceType Bounce type
     *
     * @return BouncesGetResponse Bounces data
     */
    public function getBouncesList(
        \DateTime $startDate,
        \DateTime $endDate,
        BounceType $bounceType = null
    ): BouncesGetResponse {
        return new BouncesGetResponse(
            $this->requestSender->send(new BouncesGetRequest($startDate, $endDate, $bounceType))
        );
    }
}
