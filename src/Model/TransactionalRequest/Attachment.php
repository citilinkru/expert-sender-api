<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Model\TransactionalRequest;

use Webmozart\Assert\Assert;

/**
 * Attachment
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class Attachment
{
    /**
     * @var string Filename
     */
    private $filename;

    /**
     * @var string|null MIME type
     */
    private $mimeType;

    /**
     * @var string Content
     */
    private $content;

    /**
     * Constructor.
     *
     * @param string $filename Filename
     * @param string $content Content
     * @param string $mimeType MIME type
     */
    public function __construct(string $filename, string $content, string $mimeType = null)
    {
        Assert::notEmpty($filename);
        Assert::notEmpty($content);
        if ($mimeType !== null) {
            Assert::notEmpty($mimeType);
        }

        $this->filename = $filename;
        $this->mimeType = $mimeType;
        $this->content = $content;
    }

    /**
     * Return filename
     *
     * @return string Filename
     */
    public function getFilename()
    {
        return $this->filename;
    }

    /**
     * Return MIME type
     *
     * @return null|string MIME type
     */
    public function getMimeType(): ?string
    {
        return $this->mimeType;
    }

    /**
     * Return content
     *
     * @return string Content
     */
    public function getContent(): string
    {
        return $this->content;
    }
}
