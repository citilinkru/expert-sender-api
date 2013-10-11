<?php
namespace LinguaLeo\ExpertSender;

use LinguaLeo\ExpertSender\Chunks\DataChunk;
use LinguaLeo\ExpertSender\Chunks\HeaderChunk;
use LinguaLeo\ExpertSender\Chunks\PropertiesChunk;
use LinguaLeo\ExpertSender\Chunks\PropertyChunk;
use LinguaLeo\ExpertSender\Chunks\SimpleChunk;
use LinguaLeo\ExpertSender\Results\UserIdResult;
use Psr\Log\LoggerInterface;

class ExpertSender
{

    /** @var string */
    protected $apiKey;
    protected $endpointUrl;

    /** @var HttpTransport */
    protected $transport;
    /** @var LoggerInterface */
    protected $logger;

    /**
     * @param $endpointUrl - url without /Api
     * @param $apiKey
     * @param $transport
     * @param \Psr\Log\LoggerInterface $logger
     */
    public function __construct($endpointUrl, $apiKey, $transport = null, LoggerInterface $logger = null)
    {
        if ($endpointUrl[strlen($endpointUrl) - 1] != '/') {
            $endpointUrl .= '/';
        }

        if ($transport === null) {
            $transport = new HttpTransport();
        }

        $this->endpointUrl = $endpointUrl . 'Api/';
        $this->subscribersUrl = $this->endpointUrl . 'Subscribers';
        $this->apiKey = $apiKey;
        $this->transport = $transport;
        $this->logger = $logger;
    }

    /**
     * @param $email
     * @param integer $listId
     * @param array $properties - each element must be instance of Property class
     * @param string|null $firstName
     * @param string|null $lastName
     * @param string $mode - see ExpertSenderEnum for available values
     * @param integer|null $id
     * @return ApiResult
     */
    public function addUserToList($email, $listId, $properties, $firstName = null, $lastName = null, $mode = ExpertSenderEnum::MODE_ADD_AND_UPDATE, $id = null)
    {
        $dataChunk = new DataChunk('Subscriber');
        $dataChunk->addSubChunk(new SimpleChunk('Mode', $mode));
        $dataChunk->addSubChunk(new SimpleChunk('Email', $email));
        $dataChunk->addSubChunk(new SimpleChunk('ListId', $listId));

        if ($firstName !== null) {
            $dataChunk->addSubChunk(new SimpleChunk('Firstname', $firstName));
        }

        if ($lastName !== null) {
            $dataChunk->addSubChunk(new SimpleChunk('Lastname', $lastName));
        }

        if ($id !== null) {
            $dataChunk->addSubChunk(new SimpleChunk('Id', $id));
        }

        $propertiesChunks = new PropertiesChunk();

        foreach ($properties as $property) {
            $propertiesChunks->addPropertyChunk(new PropertyChunk($property));
        }

        $dataChunk->addSubChunk($propertiesChunks);

        $headerChunk = $this->getHeaderChunk($dataChunk);

        $response = $this->transport->post($this->subscribersUrl, $headerChunk->getText());

        $apiResult = new ApiResult($response);
        $this->logApiResult(__METHOD__, $apiResult);
        return $apiResult;
    }

    /**
     * @param $email
     * @param int $listId
     * @return ApiResult
     */
    public function deleteUser($email, $listId = null)
    {
        $data = $this->getBaseData();
        $data['email'] = $email;
        if ($listId != null) {
            $data['listId'] = $listId;
        }

        $response = $this->transport->delete($this->subscribersUrl, $data);

        $apiResult = new ApiResult($response);
        $this->logApiResult(__METHOD__, $apiResult);
        return $apiResult;
    }

    public function getUserId($email)
    {
        $data = $this->getBaseData();
        $data['email'] = $email;
        $data['option'] = '3';

        $response = $this->transport->get($this->subscribersUrl, $data);

        $apiResult = new UserIdResult($response);
        $this->logApiResult(__METHOD__, $apiResult);
        return $apiResult;
    }

    public function changeEmail($listId, $from, $to)
    {
        $result = $this->getUserId($from);
        $apiResult = $this->addUserToList($to, $listId, [], null, null, ExpertSenderEnum::MODE_ADD_AND_UPDATE, $result->getId());
        $this->logApiResult(__METHOD__, $apiResult);
        return $apiResult;
    }

    protected function getHeaderChunk($dataChunk)
    {
        return new HeaderChunk($this->apiKey, $dataChunk);
    }

    protected function getBaseData()
    {
        return ['apiKey' => $this->apiKey];
    }

    /**
     * @param string $method
     * @param ApiResult $result
     */
    protected function logApiResult($method, ApiResult $result)
    {
        if (!$this->logger) {
            return;
        }
        $this->logger->debug(
            sprintf(
                'Method "%s" got ExpertSender response: %s.',
                $method,
                json_encode($result, JSON_UNESCAPED_UNICODE | JSON_FORCE_OBJECT)
            )
        );
    }

} 