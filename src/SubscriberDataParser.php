<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi;

use Citilink\ExpertSenderApi\Enum\SubscriberPropertySource;
use Citilink\ExpertSenderApi\Enum\SubscribersResponse\SubscriberPropertyType;
use Citilink\ExpertSenderApi\Exception\ParseResponseException;
use Citilink\ExpertSenderApi\Model\SubscribersGetResponse\SubscriberProperty;
use Citilink\ExpertSenderApi\Model\SubscribersGetResponse\SubscriberPropertyValue;

/**
 * Subscriber data parser
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class SubscriberDataParser
{
    /**
     * @var \SimpleXMLElement Xml
     */
    private $xml;

    /**
     * Constructor
     *
     * @param \SimpleXMLElement $xml Xml
     */
    public function __construct(\SimpleXMLElement $xml)
    {
        $this->xml = $xml;
    }

    /**
     * Get firstname of subscriber
     *
     * @return string Firstname of subscriber
     */
    public function getFirstname(): string
    {
        return strval($this->xml->Firstname);
    }

    /**
     * Get lastname of subscriber
     *
     * @return string Lastname of subscriber
     */
    public function getLastname(): string
    {
        return strval($this->xml->Lastname);
    }

    /**
     * Get IP of subscriber
     *
     * @return string IP of subscriber
     */
    public function getIp(): string
    {
        return strval($this->xml->Ip);
    }

    /**
     * Get ID of subscriber
     *
     * @return int ID of subscriber
     */
    public function getId(): int
    {
        return intval($this->xml->Id);
    }

    /**
     * Get vendor of subscriber
     *
     * @return string Vendor of subscriber
     */
    public function getVendor(): string
    {
        return strval($this->xml->Vendor);
    }

    /**
     * Get subscriber properties
     *
     * @return SubscriberProperty[] Properties
     */
    public function getProperties(): array
    {
        $nodes = $this->xml->xpath('Properties/Property');
        $properties = [];
        foreach ($nodes as $node) {
            $id = intval($node->Id);
            $source = new SubscriberPropertySource(strval($node->Source));
            $type = new SubscriberPropertyType(strval($node->Type));
            $friendlyName = strval($node->FriendlyName);
            $name = strval($node->Name);
            $description = strval($node->Description);

            $value = null;
            switch ($type->getValue()) {
                case SubscriberPropertyType::TEXT:
                case SubscriberPropertyType::URL:
                case SubscriberPropertyType::SINGLE_SELECT:
                    $value = SubscriberPropertyValue::createString(
                        strval($node->StringValue),
                        strval($node->DefaultStringValue)
                    );
                    break;
                case SubscriberPropertyType::NUMBER:
                    $value = SubscriberPropertyValue::createInt(
                        intval($node->IntValue),
                        intval($node->DefaultIntValue)
                    );
                    break;
                case SubscriberPropertyType::MONEY:
                    $value = SubscriberPropertyValue::createDecimal(
                        floatval($node->DecimalValue),
                        floatval($node->DefaultDecimalValue)
                    );
                    break;
                case SubscriberPropertyType::DATE:
                case SubscriberPropertyType::DATETIME:
                    $value = SubscriberPropertyValue::createDatetime(
                        new \DateTime(strval($node->DateTimeValue)),
                        new \DateTime(strval($node->DefaultDateTimeValue))
                    );
                    break;
                default:
                    throw new ParseResponseException(
                        sprintf(
                            'Unable recognize type and create value for subscriber\'s property. XML: [%s]',
                            $node->asXML()
                        )
                    );
            }

            $properties[] = new SubscriberProperty($id, $type, $friendlyName, $name, $description, $source, $value);
        }

        return $properties;
    }
}