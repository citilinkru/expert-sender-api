<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi;

use Citilink\ExpertSenderApi\Model\ErrorMessage;
use Psr\Http\Message\StreamInterface;

/**
 * Default response of ExpertSender API
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class Response implements ResponseInterface
{
    /**
     * @var \SimpleXMLElement SimpleXML
     */
    private $simpleXml;

    /**
     * @var string|null Response content
     */
    private $content;

    /**
     * @var \Psr\Http\Message\ResponseInterface Http response
     */
    private $httpResponse;

    /**
     * Constructor.
     *
     * @param \Psr\Http\Message\ResponseInterface $httpResponse Http response
     */
    public function __construct(\Psr\Http\Message\ResponseInterface $httpResponse)
    {
        $this->httpResponse = $httpResponse;
    }

    /**
     * @inheritdoc
     */
    public function isOk(): bool
    {
        return $this->httpResponse->getStatusCode() >= 200 && $this->httpResponse->getStatusCode() <= 299
            && $this->getErrorCode() === null;
    }

    /**
     * @inheritdoc
     */
    public function getHttpStatusCode(): int
    {
        return $this->httpResponse->getStatusCode();
    }

    /**
     * @inheritdoc
     */
    public function getErrorCode(): ?int
    {
        // all errors from api returning as xml, and if it is not xml, then no errors exist
        if (!$this->isXml()) {
            return null;
        }

        $nodes = $this->getSimpleXml()->xpath('/ApiResponse/ErrorMessage/Code');
        if (count($nodes) === 0) {
            return null;
        }

        return intval($nodes[0]);
    }

    /**
     * Get error messages
     *
     * @return ErrorMessage[] Error messages
     */
    public function getErrorMessages(): array
    {
        // all errors from api returning as xml, and if it is not xml, then no errors exist
        if (!$this->isXml()) {
            return [];
        }

        $xml = $this->getSimpleXml();
        $oneMessageNodes = $xml->xpath('/ApiResponse/ErrorMessage/Message');
        if (count($oneMessageNodes) !== 0) {
            return [new ErrorMessage(strval(reset($oneMessageNodes)))];
        }

        $messageNodes = $xml->xpath('/ApiResponse/ErrorMessage/Messages/Message');
        $messages = [];
        foreach ($messageNodes as $messageNode) {
            $messages[] = new ErrorMessage(strval($messageNode), iterator_to_array($messageNode->attributes()));
        }

        return $messages;
    }

    /**
     * @inheritdoc
     */
    public function getContent(): string
    {
        if ($this->content === null) {
            $this->httpResponse->getBody()->rewind();

            $this->content = $this->httpResponse->getBody()->getContents();
        }

        return $this->content;
    }

    /**
     * @inheritdoc
     */
    public function getStream(): StreamInterface
    {
        $this->httpResponse->getBody()->rewind();

        return $this->httpResponse->getBody();
    }

    /**
     * Get SimpleXML object of response content
     *
     * @return \SimpleXMLElement XML
     */
    private function getSimpleXml(): \SimpleXMLElement
    {
        if ($this->simpleXml === null) {
            $this->simpleXml = Utils::createSimpleXml($this->getContent());
        }

        return $this->simpleXml;
    }

    /**
     * @inheritdoc
     */
    public function isEmpty(): bool
    {
        return intval($this->httpResponse->getHeader('Content-Length')) === 0;
    }

    /**
     * Is content is xml
     *
     * @return bool Is content is xml
     */
    private function isXml(): bool
    {
        $contentTypeHeaders = $this->httpResponse->getHeader('Content-Type');
        if (empty($contentTypeHeaders)) {
            return false;
        }

        $firstContentType = reset($contentTypeHeaders);

        return !$this->isEmpty() && strpos($firstContentType, 'text/xml') !== false;
    }
}
