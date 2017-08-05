<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi;

use Citilink\ExpertSenderApi\Exception\TryToAccessDataFromErrorResponseException;
use function GuzzleHttp\Psr7\copy_to_stream;
use GuzzleHttp\Psr7\Stream;
use Psr\Http\Message\StreamInterface;

/**
 * Specific response which contains csv content
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class SpecificCsvMethodResponse implements ResponseInterface
{
    /**
     * @var ResponseInterface Response
     */
    private $response;

    /**
     * Constructor.
     *
     * @param ResponseInterface $response
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
    public function getHttpStatusCode(): int
    {
        return $this->response->getHttpStatusCode();
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
    public function getContent(): string
    {
        return $this->response->getContent();
    }

    /**
     * @inheritdoc
     */
    public function getStream(): StreamInterface
    {
        return $this->response->getStream();
    }

    /**
     * @inheritdoc
     */
    public function getErrorMessages(): array
    {
        return $this->response->getErrorMessages();
    }

    /**
     * Get csv line values without header
     *
     * @return string[][]|\Generator Csv line values
     */
    protected function getCsvLinesWithoutHeader(): \Generator
    {
        if (!$this->isOk()) {
            throw TryToAccessDataFromErrorResponseException::createFromResponse($this);
        }

        $newStream = new Stream(fopen('php://temp', 'r+'));
        copy_to_stream($this->getStream(), $newStream);
        $newStream->rewind();
        $phpStream = $newStream->detach();

        // pass header
        fgetcsv($phpStream);

        // read line by line
        while (($csvLineAsArray = fgetcsv($phpStream)) !== false) {
            // empty line protection
            if (isset($csvLineAsArray[0]) && $csvLineAsArray[0] === null) {
                continue;
            }

            yield $csvLineAsArray;
        }
    }

    /**
     * @inheritdoc
     */
    public function isEmpty(): bool
    {
        return $this->response->isEmpty();
    }
}
