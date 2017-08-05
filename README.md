Expert Sender Api
=================

[PHP API](https://sites.google.com/a/expertsender.com/api-documentation/) for [Expert Sender](http://www.expertsender.com/)

## Table of contents
- [Requirements](#requirements)
- [Installation](#installaion)
- [Usage](#usage)
- [Documentation](#documentation)
    - [Create API object](#create-api)
    - [Subscribers](#subscribers)
        - [Add/Edit](#addedit-subscriber)
        - [How to change email or phone](#How-to-change-Email-or-Phone)
        
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
### Subscribers
#### Add/Edit subscriber

[documentation](https://sites.google.com/a/expertsender.com/api-documentation/methods/subscribers/add-subscriber)
```php
// ...

use Citilink\ExpertSenderApi\Model\SubscribersPostRequest\Options;
use Citilink\ExpertSenderApi\Model\SubscribersPostRequest\Identifier;
use Citilink\ExpertSenderApi\Enum\SubscribersPostRequest\Mode;

// ...

$listId = 25;

// to add new subscriber you can use one of identifiers email or phone (but not others, read documentation for more 
// information). You can use phone identifier, if sms channel is turned on, otherwise api return 400 response.
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
$addResult = $api->subscribers->addOrEdit([$subscriberData], $options, $mode);

// after that you use response for read additional data, or errors.
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
    $api->subscriber->addOrEdit([$subscriberData]); 
    ```

- Change phone with EmailMd5:
    ```php
    $identifier = Identifier::createEmailMd5('md5');
    $subscriberData = new SubscriberData($identifier, $listId);
    $subscriberData->setPhone('9153452412');
    $api->subscriber->addOrEdit([$subscriberData]); 
    ```

- Change both with ID
    ```php
    $identifier = Identifier::createId(230584);
    $subscriberData = new SubscriberData($identifier, $listId);
    $subscriberData->setPhone('9153452412');
    $subscriberData->setEmail('new_email@mail.com');
    $api->subscriber->addOrEdit([$subscriberData]); 
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
