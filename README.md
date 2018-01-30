Expert Sender Api
=================
[![Build Status](https://travis-ci.org/citilinkru/expert-sender-api.svg?branch=master)](https://travis-ci.org/citilinkru/expert-sender-api)

[PHP API](https://sites.google.com/a/expertsender.com/api-documentation/) for [Expert Sender](http://www.expertsender.com/)

_fork of [LinguaLeo/expert-sender-api](https://github.com/LinguaLeo/expert-sender-api)_

## Table of contents
- [Requirements](#requirements)
- [Installation](#installaion)
- [Usage](#usage)
- [Documentation](#documentation)
    - [Create API object](#create-api)
    - [Get server time](#get-server-time)
    - [Messages](#messages)
        - [Send transactional messages](#send-transactional-messages)
        - [Send system transactional messages](#send-system-transactional-messages)
        - [Send trigger messages](#send-trigger-messages)
    - [Subscribers](#subscribers)
        - [Get subscriber information](#get-subscriber-information)
        - [Add/Edit subscriber](#addedit-subscriber)
            - [How to change email or phone](#how-to-change-Email-or-Phone)
        - [Delete subscriber](#delete-subscriber)
        - [Get removed subscribers](#get-removed-subscribers)
        - [Get snoozed subscribers](#get-snoozed-subscribers)
        - [Snooze subscriber](#snooze-subscriber)
        - [Get subscriber activity](#get-subscriber-activity)
        - [Get subscriber segments](#get-subscriber-segments)
        - [Get segment size](#get-segment-size)
    - [Get bounces list](#get-bounces-list)
    - [Data Tables](#data-tables)
        - [Get list of tables](#get-list-of-tables)
            - [Tables summary](#tables-summary)
            - [Table details](#table-details)
        - [Get data](#get-data)
        - [Count rows](#count-rows)
        - [Clear table](#clear-table)
        - [Add row](#add-row)
        - [Add multiple rows](#add-multiple-rows)
        - [Update row](#update-row)
        - [Delete row](#delete-row)
        - [Delete rows](#delete-rows)
        
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
$response = $api->getServerTime();
if ($response->isOk()) {
    $dateTime = $response->getServerTime();
    echo $dateTime->format('Y-m-d H:i:s');
} else {
    // handle errors
}
```
### Messages
#### Send transactional messages
[documentation](https://sites.google.com/a/expertsender.com/api-documentation/methods/messages/send-transactional-messages)
```php
// ...

use Citilink\ExpertSenderApi\Model\TransactionalPostRequest\Receiver;
use Citilink\ExpertSenderApi\Model\TransactionalPostRequest\Snippet;
use Citilink\ExpertSenderApi\Model\TransactionalPostRequest\Attachment;

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

$response = $api->messages()->sendTransactionalMessage($messageId, $receiverById, $snippets, $attachments, $returnGuid);

if ($response->isOk()) {
    // guid available, only if returnGuid=true in request
    $guid = $response->getGuid();
} else {
    // handle errors
}
```
#### Send system transactional messages
[documentation](https://sites.google.com/a/expertsender.com/api-documentation/methods/messages/send-system-transactional-messages)
```php
// ...

use Citilink\ExpertSenderApi\Model\TransactionalPostRequest\Receiver;
use Citilink\ExpertSenderApi\Model\TransactionalPostRequest\Snippet;
use Citilink\ExpertSenderApi\Model\TransactionalPostRequest\Attachment;

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

$response = $api->messages()->sendSystemTransactionalMessage($messageId, $receiverById, $snippets, $attachments, $returnGuid);

if ($response->isOk()) {
    // guid available, only if returnGuid=true in request
    $guid = $response->getGuid();
} else {
    // handle errors
}
```
#### Send trigger messages
[documentation](https://sites.google.com/a/expertsender.com/api-documentation/methods/messages/send-trigger-messages)
```php
// ...

use Citilink\ExpertSenderApi\Model\TriggersPostRequest\Receiver;

// ...

$triggerMessageId = 25;
$response = $api->messages()->sendTriggerMessage(
    $triggerMessageId,
    [
        Receiver::createFromEmail('mail@mail.com'),
        Receiver::createFromId(384636),
    ]        
);

if ($response->isOk()) {
    // do some stuff
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
##### How to change Email or Phone
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

$response = $api->subscribers()->getRemovedSubscribers($listIds, $removeTypes, $startDate, $endDate, $option);

foreach ($response->getRemovedSubscribers() as $removedSubscriber) {
    $email = $removedSubscriber->getEmail();
    // subscriber data present, only if Customs option specified
    $subscriberData = $removedSubscriber->getSubscriberData();
    $id = $subscriberData->getId();
    $properties = $subscriberData->getProperties();
}
```
#### Get snoozed subscribers
[documentation](https://sites.google.com/a/expertsender.com/api-documentation/methods/subscribers/get-snoozed-subscribers)
```php
// every parameter is optional
$listIds = [1,2,3];
$startDate = new \DateTime('2017-01-01');
$endDate = new \DateTime('2017-02-02');
$response = $api->subscribers()->getSnoozedSubscribers($listIds, $startDate, $endDate);
if ($response->isOk()) {
    foreach ($response->getSnoozedSubscribers() as $snoozedSubscriber) {
        echo $snoozedSubscriber->getEmail();
        echo $snoozedSubscriber->getListId();
        echo $snoozedSubscriber->getSnoozedUntil(); 
    }
} else {
    // handle errors
}
```
#### Snooze subscriber
[documentation](https://sites.google.com/a/expertsender.com/api-documentation/methods/subscribers/snooze-subscriber)
##### By ID
```php
// Unique subscriber identifier
$subscriberId = 12;
// Number of weeks the subscription will be snoozed for
$snoozeWeeks = 20;
// List ID
$listId = 23;

// Snooze subscriber with id #12 for 20 weeks in List #23
$snoozedByIdResponse = $api->subscribers()->snoozeSubscriberById($subscriberId, $snoozeWeeks, $listId);
if ($snoozedByIdResponse->isOk()) {
    // ok
} else {
    // handle errors
}
```
##### By Email
```php
// subscriber's email
$subscriberEmail = 'subscriber@mail.com';
// Number of weeks the subscription will be snoozed for
$snoozeWeeks = 10;

// Snooze subscriber with email 'subscriber@mail.com' for 20 weeks in all lists
$snoozedByEmailResponse = $api->subscribers()->snoozeSubscriberByEmail($subscriberEmail, $snoozeWeeks);
if ($snoozedByEmailResponse->isOk()) {
    // ok
} else {
    // handle errors
}
```
#### Get subscriber activity
[documentation](https://sites.google.com/a/expertsender.com/api-documentation/methods/get-subscriber-activity)
```php
// ...
$returnGuidInResponse = true;
$returnTitleInResponse = true;
$subscriptions = $api->subscribers()->getSubscriberActivity()->getSubscriptions(new \DateTime('2017-02-02'))
    ->getSubscriptions();

$confirmations = $api->subscribers()->getSubscriberActivity()->getConfirmations(new \DateTime('2017-02-02'))
    ->getConfirmations();

$sends = $api->subscribers()->getSubscriberActivity()->getSends(
    new \DateTime('2017-06-24'), 
    ReturnColumnsSet::STANDARD(),
    $returnGuidInResponse
)->getSends();

$opens = $api->subscribers()->getSubscriberActivity()->getOpens(
    new \DateTime('2017-06-24'), 
    ReturnColumnsSet::STANDARD(),
    $returnGuidInResponse
)->getOpens();

$clicks = $api->subscribers()->getSubscriberActivity()->getClicks(
    new \DateTime('2017-06-24'), 
    ReturnColumnsSet::STANDARD(),
    $returnTitleInResponse,
    $returnGuidInResponse
)->getClicks();

$complaints = $api->subscribers()->getSubscriberActivity()->getComplaints(
    new \DateTime('2017-06-24'), 
    ReturnColumnsSet::STANDARD(),
    $returnGuidInResponse
)->getComplaints();

$removals = $api->subscribers()->getSubscriberActivity()->getRemovals(
    new \DateTime('2017-06-24'), 
    ReturnColumnsSet::STANDARD(),
    $returnGuidInResponse
)->getRemovals();

$bounces = $api->subscribers()->getSubscriberActivity()->getBounces(
    new \DateTime('2017-06-24'), 
    ReturnColumnsSet::STANDARD(),
    $returnGuidInResponse
)->getBounces();

$goals = $api->subscribers()->getSubscriberActivity()->getGoals(
    new \DateTime('2017-06-24'), 
    ReturnColumnsSet::STANDARD(),
    $returnGuidInResponse
)->getGoals();
```
#### Get subscriber segments
[documentation](https://sites.google.com/a/expertsender.com/api-documentation/methods/get-subscriber-segments)
```php
$response = $api->subscribers()->getSubscriberSegments();
if ($response->isOk()) {
    foreach($response->getSegments() as $segment) {
        echo $segment->getId();
        echo $segment->getName();
    }
} else {
    // handle errors
}
```
#### Get segment size
[documentation](https://sites.google.com/a/expertsender.com/api-documentation/methods/get-segment-size)
```php
$segmentId = 25;
$response = $api->subscribers()->getSegmentSize($segmentId);
if ($response->isOk()) {
    echo $response->getSize();
    echo $response->getCountDate()->format('Y-m-d H:i:s);
} else {
    // handle errors
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

$response = $api->getBouncesList($startDate, $endDate, $bounceType);

foreach ($response->getBounces() as $bounce) {
    $date = $bounce->getDate();
    $email = $bounce->getEmail();
    // etc
}
```

## Data Tables
[documentation](https://sites.google.com/a/expertsender.com/api-documentation/methods/datatables)
### Get list of tables
[documentation](https://sites.google.com/a/expertsender.com/api-documentation/methods/datatables/get-list-of-tables)
#### Tables summary
```php
$response = $api->dataTables()->getTablesList();
if ($response->isOk()) {
   foreach ($response->getTables() as $table)) {
        echo $table->getId();
        echo $table->getName();
        echo $table->getColumnsCount();
        echo $table->getRelationshipsCount();
        echo $table->getRelationshipsDestinationCount();
        echo $table->getRowsCount();
        echo $table->getSize();
   }   
} else {
    // handle errors
} 
```
#### Table details
```php
$response = $api->dataTables()->getTableDetails('table-name');
if ($response->isOk()) {
    $tableDetails = $response->getTableDetails();
    echo $tableDetails->getId();
    echo $tableDetails->getName();
    echo $tableDetails->getColumnsCount();
    echo $tableDetails->getRelationshipsCount();
    echo $tableDetails->getRelationshipsDestinationCount();
    echo $tableDetails->getRowsCount();
    echo $tableDetails->getDescription();
    foreach ($tableDetails->getColumns() as $column) {
        echo $column->getName();
        echo $column->getColumnType();
        echo $column->getLength();
        echo $column->getDefaultValue() ?: 'No default value';
        echo $column->isPrimaryKey() ? 'true' : 'false';
        echo $column->isRequired() ? 'true' : 'false';
    }
} else {
    // handle errors
}
```
### Get data
[documentation](https://sites.google.com/a/expertsender.com/api-documentation/methods/datatables/get-data)
```php
// ...
use Citilink\ExpertSenderApi\Enum\DataTablesGetDataPostRequest\Direction;
use Citilink\ExpertSenderApi\Enum\DataTablesGetDataPostRequest\Operator;
use Citilink\ExpertSenderApi\Model\WhereCondition;
use Citilink\ExpertSenderApi\Model\DataTablesGetDataPostRequest\OrderByRule;
// ...
// limit is optional, and null by default
$limit = 30;
$response = $api->dataTables()->getRows(
    // table name to get data from
    'table-name',
    // array of column names to get from table
    ['ColumnName1', 'ColumnName2'],
    // where conditions to filter data
    [
        new WhereCondition('ColumnName1', Operator::EQUAL(), 'value'),
        new WhereCondition('ColumnName2', Operator::LIKE(), 'string'),
        new WhereCondition('ColumnName3', Operator::GREATER(), 24),
        new WhereCondition('ColumnName4', Operator::LOWER(), 10.54),
    ],
    // sorting rules
    [
        new OrderByRule('ColumnName1', Direction::ASCENDING()),
        new OrderByRule('ColumnName1', Direction::DESCENDING()),
    ],
    // and limit
    $limit
);

if ($response->isOk()) {
    // if everything is okay, you can get csv reader and fetch data
    $csvReader = $response->getCsvReader();
    foreach ($csvReader->fetchAll() as $row) {
        // fetched data will have column names in keys and values ... will be values
        echo $row['ColumnName1'];
        echo $row['ColumnName2'];
    }
} else {
    // handle errors
}
```
### Count rows
[documentation](https://sites.google.com/a/expertsender.com/api-documentation/methods/datatables/count-rows)
```php
// ...
use Citilink\ExpertSenderApi\Enum\DataTablesGetDataPostRequest\Operator;
use Citilink\ExpertSenderApi\Model\WhereCondition;
// ...
$response = $api->dataTables()->getRowsCount(
    'table-name',
    [
        new WhereCondition('Column1', Operator::EQUAL(), 12),
        new WhereCondition('Column2', Operator::GREATER(), 12.53),
        new WhereCondition('Column3', Operator::LOWER(), -0.56),
        new WhereCondition('Column5', Operator::LIKE(), 'string'),
    ]
);

if ($response->isOk()) {
    $count = $response->getCount();
} else {
    // handle errors
}
```
### Clear table
[documentation](https://sites.google.com/a/expertsender.com/api-documentation/methods/datatables/clear-table)
```php
$response = $api->dataTables()->clearTable('table-name');
if ($response->isOk()) {
    // table has been cleared
} else {
    // handle errors
}
```
### Add row
Use [add multiple rows method](#add-multiple-rows) to insert one row
### Add multiple rows
[documentation](https://sites.google.com/a/expertsender.com/api-documentation/methods/datatables/add-multiple-rows)
```php
// ...
use Citilink\ExpertSenderApi\Model\Column;
use Citilink\ExpertSenderApi\Model\DataTablesAddMultipleRowsPostRequest\Row;
// ...
$response = $api->dataTables()->addRows(
    // table name to insert rows
    'table-name',
    // rows to insert
    [
        new Row(
            [
                // fields to set 
                new Column('ColumnName1', 10),
                new Column('ColumnName2', 10.5),
                new Column('ColumnName3', 'string'),
            ]
        ),
        new Row(
            [
                new Column('ColumnName1', 25),
                new Column('ColumnName2', 0.45),
                new Column('ColumnName3', 'value'),
            ]
        ),
    ]
);

if ($response->isOk()) {
    // make some stuff
} else {
    // handle errors
    echo $response->getErrorCode();
    foreach ($response->getErrorMessages() as $errorMessage) {
        echo $errorMessage->getMessage();
    }
}
```
### Update row
[documentation](https://sites.google.com/a/expertsender.com/api-documentation/methods/datatables/update-row)
```php
// ...
use Citilink\ExpertSenderApi\Model\Column;
// ...
$response = $api->dataTables()->updateRow(
    // table name 
    'table-name',
    // primary keys to find row
    [
        new Column('ColumnName1', 12),
        new Column('ColumnName2', 'value'),
    ],
    // fields to change
    [
        new Column('ColumnName3', 25),
        new Column('ColumnName4', 'string'),
        new Column('ColumnName5', 25.4)
    ]
);

if ($response->isOk()) {
    // make some stuff
} else {
    // handle errors
    echo $response->getErrorCode();
    foreach ($response->getErrorMessages() as $errorMessage) {
        echo $errorMessage->getMessage();
    }
}
```
### Delete row
[documentation](https://sites.google.com/a/expertsender.com/api-documentation/methods/datatables/delete-row)
```php
// ...
use Citilink\ExpertSenderApi\Model\Column;
// ...
$response = $api->dataTables()->deleteOneRow(
    // table name to update rows
    'table-name',
    // primary keys to find row
    [
        new Column('ColumnName1', 12),
        new Column('ColumnName2', 'value'),
    ]
);

if ($response->isOk()) {
    // make some stuff
} else {
    // handle errors
    echo $response->getErrorCode();
    foreach ($response->getErrorMessages() as $errorMessage) {
        echo $errorMessage->getMessage();
    }
}
```
### Delete rows
[documentation](https://sites.google.com/a/expertsender.com/api-documentation/methods/datatables/delete-rows)
```php
// ...
use Citilink\ExpertSenderApi\Model\DataTablesDeleteRowsPostRequest\Filter;
use Citilink\ExpertSenderApi\Enum\DataTablesDeleteRowsPostRequest\FilterOperator;
// ...
$response = $api->dataTables()->deleteRows(
    'table-name',
    [
        new Filter('Column1', FilterOperator::EQ(), 12),
        new Filter('Column2', FilterOperator::GE(), 56.7),
        new Filter('Column3', FilterOperator::EQ(), 'string'),
        new Filter('Column4', FilterOperator::GT(), 89.234),
        new Filter('Column5', FilterOperator::LT(), 87.3),
        new Filter('Column6', FilterOperator::LE(), 98),
    ]
);

if ($response->isOk()) {
    $count = $response->getCount();
} else {
    // handle errors
}
```
