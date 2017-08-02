<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi;

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
     * @var int|null Error code
     */
    private $errorCode;

    /**
     * @var string|null Error message
     */
    private $errorMessage;

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

        $this->parseErrorMessage();
    }

    /**
     * Parse response for errors
     */
    private function parseErrorMessage(): void
    {
        $content = $this->getContent();
        $this->errorCode = null;
        if (preg_match("~<Code>(.+)</Code>~", $content, $matches)) {
            $this->errorCode = (int)$matches[1];
        }

        $this->errorMessage = null;
        if (preg_match("~<Message>(.+)</Message>~", $content, $matches)) {
            $this->errorMessage = $matches[1];
        }

        return;
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
        return $this->errorCode;
    }

    /**
     * @inheritdoc
     */
    public function getErrorMessage(): ?string
    {
        return $this->errorMessage;
    }

    /**
     * @inheritdoc
     */
    public function getContent(): string
    {
        $this->stream->rewind();

        return $this->getStream()->getContents();
    }

    /**
     * @inheritdoc
     */
    public function getStream()
    {
        $this->stream->rewind();

        return $this->stream;
    }
}
