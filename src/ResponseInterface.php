<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi;

use Citilink\ExpertSenderApi\Model\ErrorMessage;

/**
 * Response of ExpertSender API
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
interface ResponseInterface
{
    /**
     * Is response OK (without errors)
     *
     * @return bool Is response OK (without errors)
     */
    public function isOk(): bool;

    /**
     * Get HTTP status code
     *
     * @return int HTTP status code
     */
    public function getHttpStatusCode(): int;

    /**
     * Get error code if exists
     *
     * @return int|null Error code or null, if error not exists
     */
    public function getErrorCode(): ?int;

    /**
     * Content
     *
     * @return string Content
     */
    public function getContent(): string;

    /**
     * Stream of content
     *
     * @return resource Stream of content
     */
    public function getStream();

    /**
     * Get SimpleXML object of response content
     *
     * @return \SimpleXMLElement XML
     */
    public function getSimpleXml();

    /**
     * Get error messages
     *
     * Get error messages as array. If response has only one error, then method return array with one element, if
     * response has multiple messages, than method return all messages. All attributes of error message you can get from
     * {@see ErrorMessage::getOptions}
     *
     * @return ErrorMessage[] Error messages
     */
    public function getErrorMessages(): array;

    /**
     * Is empty
     *
     * @return bool Is empty
     */
    public function isEmpty(): bool;
}
