<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Model;

/**
 * Error message
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class ErrorMessage
{
    /**
     * @var string Message
     */
    private $message;

    /**
     * @var array Options of error message
     */
    private $options;

    /**
     * Constructor.
     *
     * @param string $message Message
     * @param array $options Options of error message
     */
    public function __construct(string $message, array $options = [])
    {
        $this->message = $message;
        $this->options = $options;
    }

    /**
     * Get message
     *
     * @return string Message
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * Get options of error message
     *
     * @return array Options of error message
     */
    public function getOptions(): array
    {
        return $this->options;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString(): string
    {
        return $this->message . '[' . implode(', ', $this->options) . ']';
    }
}
