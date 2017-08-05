<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Response;

use Citilink\ExpertSenderApi\Enum\SubscriberPropertySource;
use Citilink\ExpertSenderApi\Enum\SubscribersResponse\Type;
use Citilink\ExpertSenderApi\Exception\ParseResponseException;
use Citilink\ExpertSenderApi\Exception\TryToAccessDataFromErrorResponseException;
use Citilink\ExpertSenderApi\Model\SubscribersGetResponse\Property;
use Citilink\ExpertSenderApi\Model\SubscribersGetResponse\Value;

/**
 * Full info about subscriber
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class SubscribersGetFullResponse extends SubscribersGetLongResponse
{
    /**
     * Get firstname of subscriber
     *
     * @return string Firstname of subscriber
     */
    public function getFirstname(): string
    {
        if (!$this->isOk()) {
            throw TryToAccessDataFromErrorResponseException::createFromResponse($this);
        }

        $xml = $this->getSimpleXml();
        $nodes = $xml->xpath('/ApiResponse/Data/Firstname');
        $node = reset($nodes);

        return strval($node);
    }

    /**
     * Get lastname of subscriber
     *
     * @return string Lastname of subscriber
     */
    public function getLastname(): string
    {
        if (!$this->isOk()) {
            throw TryToAccessDataFromErrorResponseException::createFromResponse($this);
        }

        $xml = $this->getSimpleXml();
        $nodes = $xml->xpath('/ApiResponse/Data/Lastname');
        $node = reset($nodes);

        return strval($node);
    }

    /**
     * Get IP of subscriber
     *
     * @return string IP of subscriber
     */
    public function getIp(): string
    {
        if (!$this->isOk()) {
            throw TryToAccessDataFromErrorResponseException::createFromResponse($this);
        }

        $xml = $this->getSimpleXml();
        $nodes = $xml->xpath('/ApiResponse/Data/Ip');
        $node = reset($nodes);

        return strval($node);
    }

    /**
     * Get ID of subscriber
     *
     * @return int ID of subscriber
     */
    public function getId(): int
    {
        if (!$this->isOk()) {
            throw TryToAccessDataFromErrorResponseException::createFromResponse($this);
        }

        $xml = $this->getSimpleXml();
        $nodes = $xml->xpath('/ApiResponse/Data/Id');
        $node = reset($nodes);

        return intval($node);
    }

    /**
     * Get vendor of subscriber
     *
     * @return string Vendor of subscriber
     */
    public function getVendor(): string
    {
        if (!$this->isOk()) {
            throw TryToAccessDataFromErrorResponseException::createFromResponse($this);
        }

        $xml = $this->getSimpleXml();
        $nodes = $xml->xpath('/ApiResponse/Data/Vendor');
        $node = reset($nodes);

        return strval($node);
    }

    /**
     * Get subscriber properties
     *
     * @return Property[] Properties
     */
    public function getProperties(): array
    {
        if (!$this->isOk()) {
            throw TryToAccessDataFromErrorResponseException::createFromResponse($this);
        }

        $xml = $this->getSimpleXml();

        $nodes = $xml->xpath('/ApiResponse/Data/Properties/Property');
        $properties = [];
        foreach ($nodes as $node) {
            $id = intval($node->Id);
            $source = new SubscriberPropertySource(strval($node->Source));
            $type = new Type(strval($node->Type));
            $friendlyName = strval($node->FriendlyName);
            $name = strval($node->Name);
            $description = strval($node->Description);

            $value = null;
            switch ($type->getValue()) {
                case Type::TEXT:
                case Type::URL:
                case Type::SINGLE_SELECT:
                    $value = Value::createString(
                        strval($node->StringValue),
                        strval($node->DefaultStringValue)
                    );
                    break;
                case Type::NUMBER:
                    $value = Value::createInt(
                        intval($node->IntValue),
                        intval($node->DefaultIntValue)
                    );
                    break;
                case Type::MONEY:
                    $value = Value::createDecimal(
                        floatval($node->DecimalValue),
                        floatval($node->DefaultDecimalValue)
                    );
                    break;
                case Type::DATE:
                case Type::DATETIME:
                    $value = Value::createDatetime(
                        new \DateTime(strval($node->DateTimeValue)),
                        new \DateTime(strval($node->DefaultDateTimeValue))
                    );
                    break;
                default:
                    throw new ParseResponseException(
                        sprintf(
                            'Невозможно опрелить тип и создать значение для свойства подписчика. XML: [%s]',
                            $node->asXML()
                        )
                    );
            }

            $properties[] = new Property($id, $type, $friendlyName, $name, $description, $source, $value);
        }

        return $properties;
    }
}
