<?php
namespace LinguaLeo\ExpertSender;

use LinguaLeo\ExpertSender\Chunks\DataChunk;
use LinguaLeo\ExpertSender\Chunks\HeaderChunk;
use LinguaLeo\ExpertSender\Chunks\PropertiesChunk;
use LinguaLeo\ExpertSender\Chunks\PropertyChunk;
use LinguaLeo\ExpertSender\Chunks\ReceiverChunk;
use LinguaLeo\ExpertSender\Chunks\ReceiversChunk;
use LinguaLeo\ExpertSender\Chunks\SimpleChunk;
use LinguaLeo\ExpertSender\Chunks\SnippetChunk;
use LinguaLeo\ExpertSender\Chunks\SnippetsChunk;
use LinguaLeo\ExpertSender\Results\UserIdResult;

class ExpertSender
{
    protected $apiKey;

    /** @var HttpTransport */
    protected $transport;

    protected $endpointUrl;
    protected $subscribersUrl;
    protected $triggerUrlPattern;


    /**
     * @param $endpointUrl - url without /Api
     * @param $apiKey
     * @param $transport
     */
    public function __construct($endpointUrl, $apiKey, $transport = null)
    {
        if ($endpointUrl[strlen($endpointUrl) - 1] != '/') {
            $endpointUrl .= '/';
        }

        if ($transport === null) {
            $transport = new HttpTransport();
        }

        $this->endpointUrl = $endpointUrl . 'Api/';
        $this->subscribersUrl = $this->endpointUrl . 'Subscribers';
        $this->triggerUrlPattern = $this->endpointUrl . 'Triggers/%s';
        $this->transactionalUrlPattern = $this->endpointUrl . 'Transactionals/%s';
        $this->apiKey = $apiKey;
        $this->transport = $transport;
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

        return new ApiResult($response);
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

        return new ApiResult($response);
    }

    public function getUserId($email)
    {
        $data = $this->getBaseData();
        $data['email'] = $email;
        $data['option'] = '3';

        $response = $this->transport->get($this->subscribersUrl, $data);

        return new UserIdResult($response);
    }

    public function changeEmail($listId, $from, $to)
    {
        $result = $this->getUserId($from);
        $this->addUserToList($to, $listId, [], null, null, ExpertSenderEnum::MODE_ADD_AND_UPDATE, $result->getId());
    }

    /**
     * @param $triggerId
     * @param $receivers
     */
    public function sendTrigger($triggerId, $receivers)
    {
        $receiverChunks = [];
        foreach($receivers as $receiver) {
            $receiverChunks[] = new ReceiverChunk($receiver);
        }

        $receiversChunks = new ReceiversChunk($receiverChunks);
        $dataChunk = new DataChunk('TriggerReceivers');
        $dataChunk->addSubChunk($receiversChunks);
        $headerChunk = $this->getHeaderChunk($dataChunk);

        $url = sprintf($this->triggerUrlPattern, $triggerId);
        $this->transport->post($url, $headerChunk->getText());
    }

    /**
     * @param $transactionId
     * @param $receiver
     * @param $snippets
     */
    public function sendTransactional($transactionId, $receiver, $snippets)
    {
        $snippetChunks = [];
        foreach($snippets as $snippet) {
            $snippetChunks[] = new SnippetChunk($snippet);
        }

        $receiverChunk = new ReceiverChunk($receiver);
        $snippetsChunks = new SnippetsChunk($snippetChunks);
        $dataChunk = new DataChunk();
        $dataChunk->addSubChunk($receiverChunk);
        $dataChunk->addSubChunk($snippetsChunks);
        $headerChunk = $this->getHeaderChunk($dataChunk);

        $url = sprintf($this->transactionalUrlPattern, $transactionId);
        $this->transport->post($url, $headerChunk->getText());
    }

    /**
     * @param $dataChunk
     * @return HeaderChunk
     */
    protected function getHeaderChunk($dataChunk)
    {
        return new HeaderChunk($this->apiKey, $dataChunk);
    }

    protected function getBaseData()
    {
        return ['apiKey' => $this->apiKey];
    }
} 