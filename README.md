Expert Sender Api
=================

API for expert sender service

## Usage

```php
// ...

use GuzzleHttp\Client;
use Citilink\ExpertSenderApi\RequestSender;
use Citilink\ExpertSenderApi\ExpertSenderApi;
use Citilink\ExpertSenderApi\Model\SubscribersRequest\SubscriberInfo;
use Citilink\ExpertSenderApi\Model\SubscribersRequest\Options;
use Citilink\ExpertSenderApi\Model\SubscribersPostRequest\Identifier;
use Citilink\ExpertSenderApi\Enum\SubscribersPostRequest\Mode;

// ...

$httpClient = new Client(['base_uri' => 'https://api.esv2.com/']);
$requestSender = new RequestSender($httpClient, 'api-key');
$api = new ExpertSenderApi($requestSender);

$email = 'mail@mail.com';
$listId = 25;
$subscriberData = new SubscriberInfo(Identifier::createEmail($email), $listId, Mode::ADD_AND_UPDATE());
$subscriberInfo->setFirstName('John');
$subscriberInfo->setLastName('Doe');
$subscriberInfo->setVendor('vendor');
$subscriberInfo->setTrackingCode('tracking code');

$returnAdditionalDataOnResponse = true;
$useVerboseErrors = true;
$options = new Options($returnAdditionalDataOnResponse, $useVerboseErrors)

$addResult = $api->subscribers()->addOrEdit([$subscriberData], $options);

if ($addResult->isOk()) {
    // ... make some stuff
} else {
    $errorMessages = $addResult->getErrorMessages();
    $errorCode = $addResult->getErrorCode();
}

// ...
```

## Implemented functions

* subscribers
    * add and edit
    * delete
    * get
        * short
        * long
        * full
* transactionals
    * send
