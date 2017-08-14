Expert Sender Api
=================
[![Build Status](https://travis-ci.org/citilinkru/expert-sender-api.svg?branch=master)](https://travis-ci.org/citilinkru/expert-sender-api)

[PHP API](https://sites.google.com/a/expertsender.com/api-documentation/) for [Expert Sender](http://www.expertsender.com/)

## Table of contents
- [Requirements](#requirements)
- [Installation](#installaion)
- [Usage](#usage)
- [Documentation](#documentation)
    - [Create API object](#create-api)
    - [Get server time](#get-server-time)
    - [Messages](#messages)
        - [Send transactional messages](#send-transactional-messages)
    - [Subscribers](#subscribers)
        - [Get subscriber information](#get-subscriber-information)
        - [Add/Edit subscriber](#addedit-subscriber)
        - [How to change email or phone](#how-to-change-Email-or-Phone)
        - [Delete subscriber](#delete-subscriber)
        - [Get removed subscribers](#get-removed-subscribers)
    - [Get bounces list](#get-bounces-list)
        
## Requirements

- PHP 7.1.0 or greater
- [Guzzle 6](https://github.com/guzzle/guzzle) 

## Installation
The recommended way to install is through [Composer](http://getcomposer.org).
```bash
composer require citilink/expert-sender-api
```

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
$subscriberData = new SubscriberInfo(Identifier::createEmail($email), $listId);
$subscriberInfo->setFirstName('John');
$subscriberInfo->setLastName('Doe');
$subscriberInfo->setVendor('vendor');
$subscriberInfo->setTrackingCode('tracking code');
// another sets

$addResult = $api->subscribers()->addOrEdit([$subscriberData]);
if ($addResult->isOk()) {
    // ... make some stuff
} else {
    $errorMessages = $addResult->getErrorMessages();
    $errorCode = $addResult->getErrorCode();
}

// ...
```

## Documentation
### Create API
```php
use GuzzleHttp\Client;
use Citilink\ExpertSenderApi\RequestSender;
use Citilink\ExpertSenderApi\ExpertSenderApi;

// ...

// api endpoint always the same
$apiEndpoint = 'https://api.esv2.com/';

// http client must implements Guzzle's ClientInterface
$httpClient = new Client(['base_uri' => $apiEndpoint]);

// request sender object must implements RequestSenderInterface
$requestSender = new RequestSender($httpClient, 'api-key');

// now we have api object and can access to all methods of api
$api = new ExpertSenderApi($requestSender);
```
### Get server time
[documentation](https://sites.google.com/a/expertsender.com/api-documentation/methods/get-server-time)
```php
$dateTime = $api->time()->get()->getServerTime();
echo $dateTime->format('Y-m-d H:i:s');
```
### Messages
#### Send transactional messages
[documentation](https://sites.google.com/a/expertsender.com/api-documentation/methods/messages/send-transactional-messages)
```php
// ...

use Citilink\ExpertSenderApi\Model\TransactionalRequest\Receiver;
use Citilink\ExpertSenderApi\Model\TransactionalRequest\Snippet;
use Citilink\ExpertSenderApi\Model\TransactionalRequest\Attachment;

// ...

// message id is required
$messageId = 15;

// list id is optional, read documentation to get more inforamtion
$listId = 24;
$receiverByEmail = Receiver::createByEmail('mail@mail.com', $listId);
$receiverByEmailMd5 = Receiver::createByEmailMd5('md5');
$receiverById = Receiver::createById(862547);

// snippets are optional
$snippets = [];
$snippets[] = new Snippet('name1', 'value1');
$snippets[] = new Snippet('name2', 'value2');

// attachments are optional
$attachments = [];
$attachments[] = new Attachment('filename.jpeg', base64_encode('content'), 'image/jpeg');

// should response has guid of sent message
$returnGuid = true;

$response = $api->transactionals()->send($messageId, $receiverById, $snippets, $attachments, $returnGuid);

if ($response->isOk()) {
    // guid available, only if returnGuid=true in request
    $guid = $response->getGuid();
} else {
    // handle errors
}
```

### Subscribers
#### Get subscriber information
[documentation](https://sites.google.com/a/expertsender.com/api-documentation/methods/subscribers/get-subscriber-information)
```php
$subscriberEmail = 'mail@mail.com';

// get short info about subscriber
$shortInfoResponse = $api->subscribers()->getShort($subscriberEmail);

// get long info about subscriber
$longInfoResponse = $api->subscribers()->getLong($subscriberEmail);

// get full info about subscriber
$fullInfoResponse = $api->subscribers()->getFull($subscriberEmail);

// get events history
$eventsHistoryResponse = $api->subscribers()->getEventsHistory($subscriberEmail);
```
#### Add/Edit subscriber
[documentation](https://sites.google.com/a/expertsender.com/api-documentation/methods/subscribers/add-subscriber)
```php
// ...

use Citilink\ExpertSenderApi\Model\SubscribersPostRequest\Options;
use Citilink\ExpertSenderApi\Model\SubscribersPostRequest\Identifier;
use Citilink\ExpertSenderApi\Enum\SubscribersPostRequest\Mode;

// ...

$listId = 25;

// to add new subscriber you can use one of identifiers email or phone (but not others, read documentation 
// for more information). You can use phone identifier, if sms channel is turned on, otherwise api 
// return 400 response.
$emailIdentifier = Identifier::createEmail('mail@mail.com');
$phoneIdentifier = Identifier::createPhone('89159109933');

// if you want to edit subscriber you can use more identifiers
$emailMd5Indentifier = Identifier::createEmailMd5('md5');
$customSubscriberIdentifier = Identifier::createCustomSubscriberId('cuscom-subscriber-id');
$idIdentifier = Identifier::createId(100);

$identifierToUse = $emailIdentifier;
$subscriberData = new SubscriberInfo($identifierToUse, $listId);
$subscriberData->setFirsname('firstname');
// another sets...

// if you want to get additonal data on response, or verbose errors, you can create object 
// with type Options. It's optional
$returnAdditionalDataOnResponse = true;
$useVerboseErrors = true;
$options = new Options($returnAdditionalDataOnResponse, $useVerboseErrors);

// if you want use another adding mode, create it. It's optional too and by default "AddAndUpdate" 
$mode = Mode::ADD_AND_UPDATE();

// you can add more than one subscriber to request
$addOrEditResponse = $api->subscribers()->addOrEdit([$subscriberData], $options, $mode);

if ($addOrEditResponse->isOk()) {
    // do something if everything is ok
} else {
    // handle errors
}
```
#### How to change Email or Phone
To change email or phone you must choose another identifier, for example:
- if you want to change email, you can choose CustomSubscriberId, Id or Phone identifier
- if you want to change phone, you can choose Email, EmailMd5, Id or CustomSubscriberId identifier
- if you want to change both, you can choose CustomSubscriberId or Id identifier 

Code examples:
- Change email with Id:
    ```php
    $identifier = Identifier::createId(45603);
    $subscriberData = new SubscriberData($identifier, $listId);
    $subscriberData->setEmail('new_email@mail.com');
    $api->subscribers()->addOrEdit([$subscriberData]); 
    ```

- Change phone with EmailMd5:
    ```php
    $identifier = Identifier::createEmailMd5('md5');
    $subscriberData = new SubscriberData($identifier, $listId);
    $subscriberData->setPhone('9153452412');
    $api->subscribers()->addOrEdit([$subscriberData]); 
    ```

- Change both with ID
    ```php
    $identifier = Identifier::createId(230584);
    $subscriberData = new SubscriberData($identifier, $listId);
    $subscriberData->setPhone('9153452412');
    $subscriberData->setEmail('new_email@mail.com');
    $api->subscribers()->addOrEdit([$subscriberData]); 
    ```
#### Delete subscriber
[documentation](https://sites.google.com/a/expertsender.com/api-documentation/methods/subscribers/delete-subscriber)
```php
$listId = 25;
$subscriberId = 5839274;
$subscriberEmail = 'mail@mail.com';

// delete by subscriber's ID from list
$api->subscribers()->deleteById($subscriberId, $listId);

// delete by subscriber's email from every list
$api->subscribers()->deleteByEmail($subscriberEmail);
```
#### Get removed subscribers
[documentation](https://sites.google.com/a/expertsender.com/api-documentation/methods/subscribers/get-removed-subscribers)
```php
// ...

use Citilink\ExpertSenderApi\Enum\RemovedSubscribersGetRequest\RemoveType;
use Citilink\ExpertSenderApi\Enum\RemovedSubscribersGetRequest\Option;

// ...

// you can choose list ids
$listIds = [1, 2, 3];

// and/or you can choose remove types (reasons)
$removeTypes = [RemoveType::OPT_OUT_LINK(), RemoveType::USER_UNKNOWN()];

// and/or start date
$startDate = new \DateTime('2015-01-01');

// and/or end date
$endDate = new \DateTime('2016-01-01');

// and/or option. If specified, additional subscriber information will be returned
$option = Option::CUSTOMS();

$response = $api->removedSubscribers()->get($listIds, $removeTypes, $startDate, $endDate, $option);

foreach ($response->getRemovedSubscribers() as $removedSubscriber) {
    $email = $removedSubscriber->getEmail();
    // subscriber data present, only if Customs option specified
    $subscriberData = $removedSubscriber->getSubscriberData();
    $id = $subscriberData->getId();
    $properties = $subscriberData->getProperties();
}
```
### Get bounces list
[documentation](https://sites.google.com/a/expertsender.com/api-documentation/methods/get-bounces-list)
```php
// ...
use Citilink\ExpertSenderApi\Enum\BouncesGetRequest\BounceType;
// ...
$startDate = new \DateTime('2015-01-01');
$endDate = new \DateTime('2016-01-01');
// bounce type is optional, null by defalt
$bounceType = BounceType::MAILBOX_FULL();

$response = $api->bounces()->get($startDate, $endDate, $bounceType);

foreach ($response->getBounces() as $bounce) {
    $date = $bounce->getDate();
    $email = $bounce->getEmail();
    // etc
}
```
