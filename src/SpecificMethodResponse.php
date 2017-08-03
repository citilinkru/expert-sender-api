<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi;

/**
 * Specific response
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class SpecificMethodResponse implements ResponseInterface
{
    /**
     * @var ResponseInterface Response of ExpertSender API
     */
    protected $response;

    /**
     * Constructor
     *
     * @param ResponseInterface $response Response of ExpertSender API
     */
    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * @inheritdoc
     */
    public function isOk(): bool
    {
        return $this->response->isOk();
    }

    /**
     * @inheritdoc
     */
    public function getErrorCode(): ?int
    {
        return $this->response->getErrorCode();
    }

    /**
     * @inheritdoc
     */
    public function getHttpStatusCode(): int
    {
        return $this->response->getHttpStatusCode();
    }

    /**
     * @inheritdoc
     */
    public function getContent(): string
    {
        return $this->response->getContent();
    }

    /**
     * @inheritdoc
     */
    public function getStream()
    {
        return $this->response->getStream();
    }

    /**
     * @inheritdoc
     */
    public function getSimpleXml()
    {
        return $this->response->getSimpleXml();
    }

    /**
     * @inheritdoc
     */
    public function getErrorMessages(): array
    {
        return $this->response->getErrorMessages();
    }

    /**
     * @inheritdoc
     */
    public function isEmpty(): bool
    {
        return $this->response->isEmpty();
    }
}
