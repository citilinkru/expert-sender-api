<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Exception;

/**
 * Exception when response content is not valid xml and xml parsers can't work with it
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class NotValidXmlException extends ParseResponseException
{
    /**
     * @var \LibXMLError[] Xml errors
     */
    private $libXmlErrors = [];

    /**
     * Constructor.
     *
     * @param \LibXMLError[] $libXmlErrors LibXml errors
     * @param string $message Message
     * @param int $code Code
     * @param \Throwable|null $previous Previous exception
     */
    public function __construct(array $libXmlErrors, string  $message = "", int $code = 0, \Throwable $previous = null)
    {
        $errorsAsString = [];
        foreach ($libXmlErrors as $libXmlError) {
            $errorsAsString[] = sprintf('"%s"', trim($libXmlError->message), $libXmlError->level);
        }

        $allErrorsAsString = implode('; ', $errorsAsString);

        $message = sprintf('%s. Errors: %s', $message, $allErrorsAsString);

        parent::__construct($message, $code, $previous);
        $this->libXmlErrors = $libXmlErrors;
    }

    /**
     * Get xml errors
     *
     * @return \LibXMLError[] Xml error
     */
    public function getLibXmlErrors(): array
    {
        return $this->libXmlErrors;
    }
}
