<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Event;

use Citilink\ExpertSenderApi\ResponseInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Event after response received
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class ResponseReceivedEvent extends Event
{
    /**
     * @var ResponseInterface Response
     */
    private $response;

    /**
     * Constructor.
     *
     * @param ResponseInterface $response Response
     */
    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * Get response
     *
     * @return ResponseInterface Response
     */
    public function getResponse(): ResponseInterface
    {
        return $this->response;
    }
}
