<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi\Response;

use Citilink\ExpertSenderApi\Exception\ParseResponseException;
use Citilink\ExpertSenderApi\Exception\TryToAccessDataFromErrorResponseException;
use Citilink\ExpertSenderApi\SpecificXmlMethodResponse;

/**
 * Time of server response
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class TimeGetResponse extends SpecificXmlMethodResponse
{
    /**
     * Get server time
     *
     * @throws ParseResponseException If response is invalid, or Data content is not valid datetime string
     *
     * @return \DateTime Server time
     */
    public function getServerTime(): \DateTime
    {
        if (!$this->isOk()) {
            throw new TryToAccessDataFromErrorResponseException();
        }

        $xmlReader = new \XMLReader();
        $xmlReader->XML($this->getContent());
        $dataAsString = null;
        while ($xmlReader->read()) {
            if ($xmlReader->nodeType === \XMLReader::ELEMENT && $xmlReader->localName === 'Data') {
                $xmlReader->read();
                if ($xmlReader->nodeType === \XMLReader::TEXT) {
                    $dataAsString = $xmlReader->value;
                    break;
                }
            }
        }

        if ($dataAsString === null) {
            throw ParseResponseException::createFromResponse(
                'Can\'t find Data element in response',
                $this
            );
        }

        try{
            return new \DateTime($dataAsString);
        } catch (\Exception $e) {
            throw new ParseResponseException(
                sprintf('Cant\'t create DateTime object from string "%s"', $dataAsString),
                0,
                $e
            );
        }
    }
}
