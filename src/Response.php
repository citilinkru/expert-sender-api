<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi;

use Citilink\ExpertSenderApi\Exception\ParseResponseException;
use Citilink\ExpertSenderApi\Model\ErrorMessage;
use GuzzleHttp\Psr7\Stream;
use Psr\Http\Message\StreamInterface;
use Webmozart\Assert\Assert;

/**
 * Default response of ExpertSender API
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class Response implements ResponseInterface
{
    /**
     * @var int HTTP status code
     */
    private $httpStatusCode;

    /**
     * @var resource Stream
     */
    private $stream;

    /**
     * @var \SimpleXMLElement XML
     */
    private $simpleXml;

    /**
     * @var string|null Response content
     */
    private $content;

    /**
     * Creates response from string
     *
     * @param string $content Response content
     * @param int $httpStatusCode HTTP status code
     *
     * @return static Default response of ExpertSender API
     */
    public static function createFromString(string $content, int $httpStatusCode)
    {
        $stream = new Stream(fopen('php://temp', 'w+'));
        $stream->write($content);

        return new static($stream, $httpStatusCode);
    }

    /**
     * Constructor.
     *
     * @param StreamInterface $stream Stream
     * @param int $httpStatusCode HTTP status code
     */
    public function __construct(StreamInterface $stream, int $httpStatusCode)
    {
        Assert::greaterThan($httpStatusCode, 0);
        $this->httpStatusCode = $httpStatusCode;
        $this->stream = $stream;
        $this->stream->rewind();
    }

    /**
     * @inheritdoc
     */
    public function isOk(): bool
    {
        return $this->httpStatusCode >= 200 && $this->httpStatusCode <= 299 && $this->getErrorCode() === null;
    }

    /**
     * @inheritdoc
     */
    public function getHttpStatusCode(): int
    {
        return $this->httpStatusCode;
    }

    /**
     * @inheritdoc
     */
    public function getErrorCode(): ?int
    {
        if ($this->isEmpty()) {
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
        if ($this->isEmpty()) {
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
            $this->stream->rewind();

            $this->content = $this->getStream()->getContents();
        }

        return $this->content;
    }

    /**
     * @inheritdoc
     */
    public function getStream(): StreamInterface
    {
        $this->stream->rewind();

        return $this->stream;
    }

    /**
     * @inheritdoc
     */
    public function getSimpleXml(): \SimpleXMLElement
    {
        if ($this->simpleXml === null) {
            if ($this->isEmpty()) {
                throw new ParseResponseException(
                    'Response is empty, it\'s impossible to create simpleXML element. Maybe it is error, or response '
                    . 'does not have content. You can use method isEmpty before trying to get SimpleXML'
                );
            }
            $this->simpleXml = simplexml_load_string($this->getContent());
        }

        return $this->simpleXml;
    }

    /**
     * @inheritdoc
     */
    public function isEmpty(): bool
    {
        return $this->getContent() === '';
    }
}
