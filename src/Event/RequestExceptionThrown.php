<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Event;

use Citilink\ExpertSenderApi\RequestInterface;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\EventDispatcher\Event;

/**
 * Event on exception thrown while making request
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class RequestExceptionThrown extends Event
{
    /**
     * @var RequestInterface Request
     */
    private $request;

    /**
     * @var RequestException $exception
     */
    private $exception;

    /**
     * Constructor
     *
     * @param RequestInterface $apiRequest Api request
     * @param RequestException $exception Thrown exception
     */
    public function __construct(RequestInterface $apiRequest, RequestException $exception)
    {
        $this->request = $apiRequest;
        $this->exception = $exception;
    }

    /**
     * Get api request
     *
     * @return RequestInterface Api request
     */
    public function getRequest(): RequestInterface
    {
        return $this->request;
    }

    /**
     * Get thrown exception
     *
     * @return RequestException Thrown exception
     */
    public function getException(): RequestException
    {
        return $this->exception;
    }
}
