<?php
declare(strict_types=1);

namespace Citilink\ExpertSenderApi;

use Citilink\ExpertSenderApi\Enum\HttpMethod;
use Citilink\ExpertSenderApi\Event\RequestExceptionThrown;
use Citilink\ExpertSenderApi\Event\ResponseReceivedEvent;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\RequestException;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Expert Sender request sender
 *
 * @author Nikita Sapogov <sapogov.n@citilink.ru>
 */
class RequestSender implements RequestSenderInterface
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
     * @var EventDispatcherInterface Event dispatcher
     */
    private $eventDispatcher;

    /**
     * Constructor.
     *
     * @param ClientInterface $httpClient Http client
     * @param string $apiKey API Key
     * @param EventDispatcherInterface $eventDispatcher Event dispatcher (optional, specify only if you want
     *      listen events)
     */
    public function __construct(
        ClientInterface $httpClient,
        string $apiKey,
        EventDispatcherInterface $eventDispatcher = null
    ) {
        $this->httpClient = $httpClient;
        $this->apiKey = $apiKey;
        $this->eventDispatcher = $eventDispatcher ?: new EventDispatcher();
    }

    /**
     * @inheritdoc
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
            $httpResponse = $this->httpClient->request($request->getMethod()->getValue(), $request->getUri(), $options);
        } catch (RequestException $e) {
            $this->eventDispatcher->dispatch(
                'expert_sender_api.request.exception_thrown',
                new RequestExceptionThrown($request, $e)
            );

            if ($e->getResponse() !== null) {
                $httpResponse = $e->getResponse();
            } else {
                $errorMessage = sprintf(
                    'ES API ARTIFICIAL ERROR: "%s":"%s". Please note, that this error '
                    . 'indicates about exception without response. You can subscribe for '
                    . '"expert_sender_api.request.exception_thrown" event and get more information about exception',
                    get_class($e),
                    $e->getMessage()
                );

                $xml = '<ApiResponse xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"'
                    . ' xmlns:xsd="http://www.w3.org/2001/XMLSchema">
                    <ErrorMessage>
                        <Code>400</Code>
                        <Message>' . $errorMessage . '</Message>
                    </ErrorMessage>
                </ApiResponse>';

                $httpResponse = new \GuzzleHttp\Psr7\Response(
                    400,
                    ['Content-Type' => 'text/xml', 'Content-Length' => strlen($xml)],
                    $xml
                );
            }
        }

        $apiResponse = new Response($httpResponse);
        $this->eventDispatcher->dispatch(
            'expert_sender_api.response.received',
            new ResponseReceivedEvent($apiResponse)
        );

        return $apiResponse;
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
