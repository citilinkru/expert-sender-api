<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi;

use Psr\Http\Message\StreamInterface;

/**
 * Specific response which contains xml content
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class SpecificXmlMethodResponse implements ResponseInterface
{
    /**
     * @var ResponseInterface Response of ExpertSender API
     */
    protected $response;

    /**
     * @var \SimpleXMLElement SimpleXML
     */
    private $simpleXml;

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
     * {@inheritdoc}
     */
    public function isOk(): bool
    {
        return $this->response->isOk();
    }

    /**
     * {@inheritdoc}
     */
    public function getErrorCode(): ?int
    {
        return $this->response->getErrorCode();
    }

    /**
     * {@inheritdoc}
     */
    public function getHttpStatusCode(): int
    {
        return $this->response->getHttpStatusCode();
    }

    /**
     * {@inheritdoc}
     */
    public function getContent(): string
    {
        return $this->response->getContent();
    }

    /**
     * {@inheritdoc}
     */
    public function getStream(): StreamInterface
    {
        return $this->response->getStream();
    }

    /**
     * Get SimpleXML object of response content
     *
     * @return \SimpleXMLElement XML
     */
    public function getSimpleXml(): \SimpleXMLElement
    {
        if ($this->simpleXml === null) {
            $this->simpleXml = Utils::createSimpleXml($this->getContent());
        }

        return $this->simpleXml;
    }

    /**
     * {@inheritdoc}
     */
    public function getErrorMessages(): array
    {
        return $this->response->getErrorMessages();
    }

    /**
     * {@inheritdoc}
     */
    public function isEmpty(): bool
    {
        return $this->response->isEmpty();
    }
}
