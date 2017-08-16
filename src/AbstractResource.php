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
     * @var RequestSenderInterface Request sender
     */
    protected $requestSender;

    /**
     * Constructor.
     *
     * @param RequestSenderInterface $requestSender Request sender
     */
    public function __construct(RequestSenderInterface $requestSender)
    {
        $this->requestSender = $requestSender;
    }
}
