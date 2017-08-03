<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Request;

use Citilink\ExpertSenderApi\Enum\HttpMethod;
use Citilink\ExpertSenderApi\Enum\SubscribersPostRequest\MatchingMode;
use Citilink\ExpertSenderApi\Exception\ExpertSenderApiException;
use Citilink\ExpertSenderApi\Model\SubscribersPostRequest\Options;
use Citilink\ExpertSenderApi\Model\SubscribersPostRequest\SubscriberInfo;
use Citilink\ExpertSenderApi\RequestInterface;
use Citilink\ExpertSenderApi\Utils;
use Webmozart\Assert\Assert;

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
     * @var Options Options
     */
    private $options;

    /**
     * @var SubscriberInfo[] Subscribers information list
     */
    private $subscriberInfos;

    /**
     * Constructor
     *
     * @param SubscriberInfo[] $subscriberInfos Subscribers information list
     * @param Options $options Options
     */
    public function __construct(array $subscriberInfos, Options $options = null)
    {
        Assert::allIsInstanceOf($subscriberInfos, SubscriberInfo::class);
        $this->options = $options ?: new Options();
        $this->subscriberInfos = $subscriberInfos;
    }

    /**
     * @inheritdoc
     */
    public function toXml(): string
    {
        $xmlWriter = new \XMLWriter();
        $xmlWriter->openMemory();
        $xmlWriter->startElement('MultiData');
        foreach ($this->subscriberInfos as $subscriberInfo) {
            $xmlWriter->startElement('Subscriber');
            $this->writeSubscriberDataToXml($xmlWriter, $subscriberInfo);
            $xmlWriter->endElement(); // Subscriber
        }

        $xmlWriter->endElement(); // MultiData
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
     * Writer in XMLWriter elements with subscriber info
     *
     * @param \XMLWriter $xmlWriter Xml writer
     * @param SubscriberInfo $subscriberInfo Subscriber info
     */
    private function writeSubscriberDataToXml(\XMLWriter $xmlWriter, SubscriberInfo $subscriberInfo)
    {
        $xmlWriter->writeElement('Mode', $subscriberInfo->getMode()->getValue());
        $xmlWriter->writeElement('ListId', strval($subscriberInfo->getListId()));
        $xmlWriter->writeElement('MatchingMode', $subscriberInfo->getIdentifier()->getMatchingMode()->getValue());

        switch ($subscriberInfo->getIdentifier()->getMatchingMode()->getValue()) {
            case MatchingMode::CUSTOMER_SUBSCRIBER_ID:
                $xmlWriter->writeElement(
                    'CustomSubscriberId',
                    $subscriberInfo->getIdentifier()->getCustomSubscriberId()
                );
                break;
            case MatchingMode::ID:
                $xmlWriter->writeElement('Id', strval($subscriberInfo->getIdentifier()->getId()));
                break;
            case MatchingMode::EMAIL:
                if (!empty($subscriberInfo->getIdentifier()->getEmail())) {
                    $xmlWriter->writeElement('Email', $subscriberInfo->getIdentifier()->getEmail());
                } elseif (!empty($subscriberInfo->getIdentifier()->getEmailMd5())) {
                    $xmlWriter->writeElement('EmailMd5', $subscriberInfo->getIdentifier()->getEmailMd5());
                } else {
                    throw new ExpertSenderApiException('Both email and md5 of email are empty');
                }
                break;
            case MatchingMode::PHONE():
                $xmlWriter->writeElement('Phone', $subscriberInfo->getIdentifier()->getPhone());
                break;
            default:
                throw new ExpertSenderApiException(
                    sprintf(
                        'Unknown matching mode "%s"',
                        $subscriberInfo->getIdentifier()->getMatchingMode()->getValue()
                    )
                );
        }

        if ($subscriberInfo->isForce()) {
            $xmlWriter->writeElement('Force', Utils::convertBoolToStringEquivalent($subscriberInfo->isForce()));
        }

        if (!$subscriberInfo->isAllowAddUserThatWasUnsubscribed()) {
            $xmlWriter->writeElement(
                'AllowUnsubscribed',
                Utils::convertBoolToStringEquivalent($subscriberInfo->isAllowAddUserThatWasUnsubscribed())
            );
        }

        if (!$subscriberInfo->isAllowAddUserThatWasDeleted()) {
            $xmlWriter->writeElement(
                'AllowRemoved',
                Utils::convertBoolToStringEquivalent($subscriberInfo->isAllowAddUserThatWasDeleted())
            );
        }

        // ignore, if identifier is email
        if (!empty($subscriberInfo->getEmail())
            && !$subscriberInfo->getIdentifier()->getMatchingMode()->equals(MatchingMode::EMAIL())
        ) {
            $xmlWriter->writeElement('Email', $subscriberInfo->getEmail());
        }

        // ignore, if identifier is custom subscriber id
        if (!empty($subscriberInfo->getCustomSubscriberId())
            && !$subscriberInfo->getIdentifier()->getMatchingMode()->equals(MatchingMode::CUSTOMER_SUBSCRIBER_ID())) {
            $xmlWriter->writeElement('CustomSubscriberId', $subscriberInfo->getCustomSubscriberId());
        }

        // ignore, if identifier is phone
        if (!empty($subscriberInfo->getPhone())
            && !$subscriberInfo->getIdentifier()->getMatchingMode()->equals(MatchingMode::PHONE())
        ) {
            $xmlWriter->writeElement('Phone', $subscriberInfo->getPhone());
        }

        if (!empty($subscriberInfo->getFirstName())) {
            $xmlWriter->writeElement('FirstName', $subscriberInfo->getFirstName());
        }

        if (!empty($subscriberInfo->getLastName())) {
            $xmlWriter->writeElement('LastName', $subscriberInfo->getLastName());
        }

        if (!empty($subscriberInfo->getName())) {
            $xmlWriter->writeElement('Name', $subscriberInfo->getName());
        }

        if (!empty($subscriberInfo->getIp())) {
            $xmlWriter->writeElement('Ip', $subscriberInfo->getIp());
        }

        if (!empty($subscriberInfo->getTrackingCode())) {
            $xmlWriter->writeElement('TrackingCode', $subscriberInfo->getTrackingCode());
        }

        if (!empty($subscriberInfo->getVendor())) {
            $xmlWriter->writeElement('Vendor', $subscriberInfo->getVendor());
        }

        $properties = $subscriberInfo->getProperties();
        if (!empty($properties)) {
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
