<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Request;

use Citilink\ExpertSenderApi\Model\TransactionalPostRequest\Attachment;
use Citilink\ExpertSenderApi\Model\TransactionalPostRequest\Snippet;
use Citilink\ExpertSenderApi\Enum\HttpMethod;
use Citilink\ExpertSenderApi\Model\TransactionalPostRequest\Receiver;
use Citilink\ExpertSenderApi\RequestInterface;
use Citilink\ExpertSenderApi\Utils;
use Webmozart\Assert\Assert;

/**
 * Send transactional message request
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class TransactionalPostRequest implements RequestInterface
{
    /**
     * @var int Transaction message ID
     */
    private $transactionMessageId;

    /**
     * @var bool Should return GUID in Response
     */
    private $returnGuid;

    /**
     * @var Receiver Receiver
     */
    private $receiver;

    /**
     * @var Snippet[] Snippets
     */
    private $snippets;

    /**
     * @var Attachment[] Attachments
     */
    private $attachments;

    /**
     * Constructor
     *
     * @param int $transactionMessageId Transaction message ID
     * @param Receiver $receiver Receiver
     * @param Snippet[] $snippets Snippets
     * @param Attachment[] $attachments Attachments
     * @param bool $returnGuid Should return GUID in Response
     */
    public function __construct(
        int $transactionMessageId,
        Receiver $receiver,
        array $snippets = [],
        array $attachments = [],
        bool $returnGuid = false
    ) {
        Assert::greaterThan($transactionMessageId, 0);
        Assert::allIsInstanceOf($snippets, Snippet::class);
        Assert::allIsInstanceOf($attachments, Attachment::class);
        $this->transactionMessageId = $transactionMessageId;
        $this->returnGuid = $returnGuid;
        $this->receiver = $receiver;
        $this->snippets = $snippets;
        $this->attachments = $attachments;
    }

    /**
     * @inheritdoc
     */
    public function toXml(): string
    {
        $xmlWriter = new \XMLWriter();
        $xmlWriter->openMemory();

        $xmlWriter->startElement('Data');
        $xmlWriter->startElement('Receiver');
        if (!empty($this->receiver->getId())) {
            $xmlWriter->writeElement('Id', strval($this->receiver->getId()));
        }

        if (!empty($this->receiver->getEmail())) {
            $xmlWriter->writeElement('Email', $this->receiver->getEmail());
        }

        if (!empty($this->receiver->getEmailMd5())) {
            $xmlWriter->writeElement('EmailMd5', $this->receiver->getEmailMd5());
        }

        if (!empty($this->receiver->getListId())) {
            $xmlWriter->writeElement('ListId', strval($this->receiver->getListId()));
        }

        $xmlWriter->endElement(); // Receiver

        if (!empty($this->snippets)) {
            $xmlWriter->startElement('Snippets');
            foreach ($this->snippets as $snippet) {
                $xmlWriter->startElement('Snippet');
                $xmlWriter->writeElement('Name', $snippet->getName());
                $isValueHasHtmlTags = $snippet->getValue() != strip_tags($snippet->getValue());
                if ($isValueHasHtmlTags) {
                    $xmlWriter->startElement('Value');
                    $xmlWriter->writeCData($snippet->getValue());
                    $xmlWriter->endElement(); // Value
                } else {
                    $xmlWriter->writeElement('Value', $snippet->getValue());
                }

                $xmlWriter->endElement(); // Snippet
            }

            $xmlWriter->endElement(); // Snippets
        }

        if (!empty($this->attachments)) {
            $xmlWriter->startElement('Attachments');
            foreach ($this->attachments as $attachment) {
                $xmlWriter->startElement('Attachment');
                $xmlWriter->writeElement('FileName', $attachment->getFilename());
                $xmlWriter->writeElement('Content', $attachment->getContent());
                if (!empty($attachment->getMimeType())) {
                    $xmlWriter->writeElement('MimeType', $attachment->getMimeType());
                }

                $xmlWriter->endElement(); // Attachment
            }

            $xmlWriter->endElement(); // Attachments
        }

        if ($this->returnGuid) {
            $xmlWriter->writeElement('ReturnGuid', Utils::convertBoolToStringEquivalent($this->returnGuid));
        }

        $xmlWriter->endElement(); // Data

        return $xmlWriter->flush(true);
    }

    /**
     * @inheritdoc
     */
    public function getMethod(): HttpMethod
    {
        return HttpMethod::POST();
    }

    /**
     * @inheritdoc
     */
    public function getUri(): string
    {
        return '/Api/Transactionals/' . $this->transactionMessageId;
    }

    /**
     * @inheritdoc
     */
    public function getQueryParams(): array
    {
        return [];
    }
}
