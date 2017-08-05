<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi;

use Citilink\ExpertSenderApi\Enum\HttpMethod;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;

/**
 * Expert Sender request sender
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class RequestSender
{
    /**
     * @var ClientInterface Http client
     */
    private $httpClient;

    /**
     * @var string API Key
     */
    private $apiKey;

    /**
     * Constructor.
     *
     * @param ClientInterface $httpClient Http client
     * @param string $apiKey API Key
     */
    public function __construct(ClientInterface $httpClient, string $apiKey)
    {
        $this->httpClient = $httpClient;
        $this->apiKey = $apiKey;
    }

    /**
     * Send request
     *
     * @param RequestInterface $request Request
     *
     * @return ResponseInterface Response
     */
    public function send(RequestInterface $request): ResponseInterface
    {
        $options = [
            'headers' => [
                'content-type' => 'text/xml',
            ],
            'query' => $request->getQueryParams(),
        ];
        if ($request->getMethod()->equals(HttpMethod::POST())) {
            $options['body'] = $this->createApiRequestXmlFromRequest($request);
        }

        if ($request->getMethod()->equals(HttpMethod::GET()) || $request->getMethod()->equals(HttpMethod::DELETE())) {
            $options['query']['apiKey'] = $this->apiKey;
        }

        try {
            $response = $this->httpClient->request($request->getMethod()->getValue(), $request->getUri(), $options);
        } catch (RequestException $e) {
            return new Response($e->getResponse());
        }

        return new Response($response);
    }

    /**
     * Create XML string for POST-like request
     *
     * @param RequestInterface $request Request
     *
     * @return string XML string for POST-like request
     */
    private function createApiRequestXmlFromRequest(RequestInterface $request): string
    {
        return '<ApiRequest xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" '
            . 'xmlns:xs="http://www.w3.org/2001/XMLSchema"><ApiKey>' . $this->apiKey . '</ApiKey>' . $request->toXml()
            . '</ApiRequest>';
    }
}
