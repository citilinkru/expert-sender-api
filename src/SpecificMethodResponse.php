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
     * @var \SimpleXMLElement XML
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
    public function getErrorMessage(): ?string
    {
        return $this->response->getErrorMessage();
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
     * Return SimpleXML object of response content
     *
     * @return \SimpleXMLElement XML
     */
    protected function getSimpleXml()
    {
        if ($this->simpleXml === null) {
            $this->simpleXml = simplexml_load_string($this->getContent());
        }

        return $this->simpleXml;
    }
}
