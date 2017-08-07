<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi;

use Citilink\ExpertSenderApi\Enum\SubscriberPropertySource;
use Citilink\ExpertSenderApi\Enum\SubscribersResponse\SubscriberPropertyType;
use Citilink\ExpertSenderApi\Exception\ParseResponseException;
use Citilink\ExpertSenderApi\Model\SubscriberData;
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
     * Parse xml element into subscriber's data object
     *
     * @param \SimpleXMLElement $xml Xml element with subscriber data
     *
     * @return SubscriberData Subscriber's data
     */
    public function parse(\SimpleXMLElement $xml)
    {
        return new SubscriberData(
            intval($xml->Id),
            strval($xml->Firstname),
            strval($xml->Lastname),
            strval($xml->Ip),
            strval($xml->Vendor),
            $this->getProperties($xml)
        );
    }

    /**
     * Get subscriber properties
     *
     * @param \SimpleXmlElement $xml Xml element with properties
     *
     * @return SubscriberProperty[]|\Generator Properties
     */
    private function getProperties(\SimpleXmlElement $xml): \Generator
    {
        $nodes = $xml->xpath('Properties/Property');
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
                case SubscriberPropertyType::BOOLEAN:
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

            yield new SubscriberProperty($id, $type, $friendlyName, $name, $description, $source, $value);
        }
    }
}
