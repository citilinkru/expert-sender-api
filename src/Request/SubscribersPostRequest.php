<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Request;

use Citilink\ExpertSenderApi\Enum\HttpMethod;
use Citilink\ExpertSenderApi\Enum\SubscribersRequest\Mode;
use Citilink\ExpertSenderApi\Exception\ExpertSenderApiException;
use Citilink\ExpertSenderApi\Model\SubscribersRequest\Options;
use Citilink\ExpertSenderApi\Model\SubscribersRequest\SubscriberInfo;
use Citilink\ExpertSenderApi\RequestInterface;
use Citilink\ExpertSenderApi\Utils;

/**
 * Request for add/edit subscriber
 *
 * @see https://sites.google.com/a/expertsender.com/api-documentation/methods/subscribers/add-subscriber
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class SubscribersPostRequest implements RequestInterface
{
    /**
     * @var int List Id
     */
    private $listId;

    /**
     * Subscriber ID
     *
     * If you want to change Email address for a subscriber you have to provide BOTH Email and Id fields
     *
     * @var int|null
     */
    private $id;

    /**
     * @var string|null Email
     */
    private $email;

    /**
     * @var string|null Email MD5
     */
    private $emailMd5;

    /**
     * @var Mode Adding mode
     */
    private $mode;

    /**
     * @var Options Options
     */
    private $options;

    /**
     * @var SubscriberInfo Subscriber data for add/edit subscriber request
     */
    private $subscriberInfo;

    /**
     * Create request for add/edit subscriber
     *
     * @param string $email Email
     * @param int $listId List ID
     * @param SubscriberInfo $subscriberData Subscriber data for add/edit subscriber request
     * @param Mode|null $mode Adding mode
     * @param Options|null $options Options
     *
     * @throws ExpertSenderApiException If mode doesn't have add modifier
     *
     * @return static Request for add/edit subscriber
     */
    public static function createAddSubscriber(
        string $email,
        int $listId,
        SubscriberInfo $subscriberData,
        Mode $mode = null,
        Options $options = null
    ) {
        if ($mode === null) {
            $mode = Mode::ADD_AND_UPDATE();
        }

        if (!$mode->isAddEnabled()) {
            throw new ExpertSenderApiException('Choose another mod, which has add modifier');
        }

        $obj = new static($listId, $mode, $subscriberData, $options);
        $obj->email = $email;

        return $obj;
    }

    /**
     * Create request for change subscriber's email
     *
     * @param int $id Subscriber ID
     * @param string $email Email
     * @param int $listId List ID
     * @param Options|null $options Options
     *
     * @return static Request for change subscriber's email
     */
    public static function createChangeEmail(
        int $id,
        string $email,
        int $listId,
        Options $options = null
    ) {
        $obj = new static($listId, Mode::IGNORE_AND_UPDATE(), new SubscriberInfo(), $options);
        $obj->id = $id;
        $obj->email = $email;

        return $obj;
    }

    /**
     * Create request for edit subscriber by email
     *
     * @param string $email Email
     * @param int $listId List ID
     * @param SubscriberInfo $subscriberData Subscriber data
     * @param Mode|null $mode Adding mode
     * @param Options|null $options Options
     *
     * @throws ExpertSenderApiException If mode doesn't have edit modifier
     *
     * @return static Request for edit subscriber by email
     */
    public static function createEditSubscriberWithEmail(
        string $email,
        int $listId,
        SubscriberInfo $subscriberData,
        Mode $mode = null,
        Options $options = null
    ) {
        if ($mode === null) {
            $mode = Mode::ADD_AND_UPDATE();
        }

        if (!$mode->isEditEnabled()) {
            throw new ExpertSenderApiException('Choose another mod, which has edit modifier');
        }

        $obj = new static($listId, $mode, $subscriberData, $options);
        $obj->email = $email;

        return $obj;
    }

    /**
     * Create request for edit subscriber by md5 of email
     *
     * @param string $emailMd5 Email MD5
     * @param int $listId List ID
     * @param SubscriberInfo $subscriberData Subscriber data
     * @param Mode|null $mode Adding mode
     * @param Options|null $options Options
     *
     * @return static Request for edit subscriber by md5 of email
     */
    public static function createEditSubscriberWithEmailMd5(
        string $emailMd5,
        int $listId,
        SubscriberInfo $subscriberData,
        Mode $mode = null,
        Options $options = null
    ) {
        if ($mode === null) {
            $mode = Mode::ADD_AND_UPDATE();
        }
        if (!$mode->isEditEnabled()) {
            throw new ExpertSenderApiException('Choose another mod, which has edit modifier');
        }

        $obj = new static($listId, $mode, $subscriberData, $options);
        $obj->emailMd5 = $emailMd5;

        return $obj;
    }

    /**
     * Constructor
     *
     * @param int $listId List ID
     * @param Mode $mode Adding mode
     * @param SubscriberInfo $subscriberInfo Subscriber information
     * @param Options $options Options
     */
    private function __construct(
        int $listId,
        Mode $mode,
        SubscriberInfo $subscriberInfo,
        Options $options = null
    ) {
        $this->listId = $listId;
        $this->mode = $mode;
        $this->options = $options ?: new Options();
        $this->subscriberInfo = $subscriberInfo;
    }

    /**
     * @inheritdoc
     */
    public function toXml(): string
    {
        $xmlWriter = new \XMLWriter();
        $xmlWriter->openMemory();
        $xmlWriter->startElement('Data');
        $xmlWriter->writeAttributeNS('xsi', 'type', null, 'Subscriber');
        $xmlWriter->writeElement('Mode', $this->mode->getValue());
        $xmlWriter->writeElement('ListId', strval($this->listId));

        if ($this->options->isForce()) {
            $xmlWriter->writeElement('Force', Utils::convertBoolToStringEquivalent($this->options->isForce()));
        }

        if (!$this->options->isAllowAddUserThatWasUnsubscribed()) {
            $xmlWriter->writeElement(
                'AllowUnsubscribed',
                Utils::convertBoolToStringEquivalent($this->options->isAllowAddUserThatWasUnsubscribed())
            );
        }

        if (!$this->options->isAllowAddUserThatWasDeleted()) {
            $xmlWriter->writeElement(
                'AllowRemoved',
                Utils::convertBoolToStringEquivalent($this->options->isAllowAddUserThatWasDeleted())
            );
        }

        if (!empty($this->id)) {
            $xmlWriter->writeElement('Id', strval($this->id));
        }

        if (!empty($this->email)) {
            $xmlWriter->writeElement('Email', $this->email);
        }

        if (!empty($this->emailMd5)) {
            $xmlWriter->writeElement('EmailMd5', $this->emailMd5);
        }

        if (!empty($this->subscriberInfo->getFirstName())) {
            $xmlWriter->writeElement('FirstName', $this->subscriberInfo->getFirstName());
        }

        if (!empty($this->subscriberInfo->getLastName())) {
            $xmlWriter->writeElement('LastName', $this->subscriberInfo->getLastName());
        }

        if (!empty($this->subscriberInfo->getName())) {
            $xmlWriter->writeElement('Name', $this->subscriberInfo->getName());
        }

        if (!empty($this->subscriberInfo->getIp())) {
            $xmlWriter->writeElement('Ip', $this->subscriberInfo->getIp());
        }

        if (!empty($this->subscriberInfo->getTrackingCode())) {
            $xmlWriter->writeElement('TrackingCode', $this->subscriberInfo->getTrackingCode());
        }

        if (!empty($this->subscriberInfo->getVendor())) {
            $xmlWriter->writeElement('Vendor', $this->subscriberInfo->getVendor());
        }

        $properties = $this->subscriberInfo->getProperties();
        if(!empty($properties)) {
            $xmlWriter->startElement('Properties');
            foreach ($properties as $property) {
                $xmlWriter->startElement('Property');
                $xmlWriter->writeElement('Id', strval($property->getId()));
                $xmlWriter->startElement('Value');
                $xmlWriter->writeAttributeNS('xsi', 'type', null, 'xs:' . $property->getValue()->getType()->getValue());
                $xmlWriter->text($property->getValue()->getValue());
                $xmlWriter->endElement(); // Value
                $xmlWriter->endElement(); // Property
            }

            $xmlWriter->endElement(); // Properties
        }
        $xmlWriter->endElement(); // Data
        if ($this->options->isUseVerboseErrors()) {
            $xmlWriter->writeElement(
                'VerboseErrors',
                Utils::convertBoolToStringEquivalent($this->options->isUseVerboseErrors())
            );
        }

        if ($this->options->isReturnAdditionalDataOnResponse()) {
            $xmlWriter->writeElement(
                'ReturnData',
                Utils::convertBoolToStringEquivalent($this->options->isReturnAdditionalDataOnResponse())
            );
        }

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
        return '/Api/Subscribers';
    }

    /**
     * @inheritdoc
     */
    public function getQueryParams(): array
    {
        return [];
    }
}
