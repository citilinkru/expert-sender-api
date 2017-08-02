<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi;

/**
 * Abstract resource
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class AbstractResource
{
    /**
     * @var RequestSender Request sender
     */
    protected $requestSender;

    /**
     * Constructor.
     *
     * @param RequestSender $requestSender Request sender
     */
    public function __construct(RequestSender $requestSender)
    {
        $this->requestSender = $requestSender;
    }
}
