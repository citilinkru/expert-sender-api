<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi;

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
     * Return HTTP status code
     *
     * @return int HTTP status code
     */
    public function getHttpStatusCode(): int;

    /**
     * Return error code if exists
     *
     * @return int|null Error code or null, if error not exists
     */
    public function getErrorCode(): ?int;

    /**
     * Return error message if exists
     *
     * @return null|string Error message or null, if error not exists
     */
    public function getErrorMessage(): ?string;

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
}
