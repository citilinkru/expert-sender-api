Expert Sender Api
=================

API for expert sender service

## Usage

```php
$httpClient = new Client(['base_uri' => 'https://api.esv2.com/']);
$requestSender = new RequestSender($httpClient, 'api-key');
$api = new ExpertSenderApi($requestSender);

$email = 'mail@mail.com';
$subscriberInfo = new SubscriberInfo();
$subscriberInfo->setFirstName('John');
$subscriberInfo->setLastName('Doe');
$subscriberInfo->setVendor('vendor');
$subscriberInfo->setTrackingCode('tracking code');

$addResult = $this->api->subscribers()->add(
    $email,
    $this->getTestListId(),
    $subscriberInfo,
    Mode::ADD_AND_UPDATE()
);

if ($addResult->isOk()) {
    // ...
} else {
    $errorMessage = $addResult->getErrorMessage();
    $errorCode = $addResult->getErrorCode();
}
```

## Implemented functions

* subscribers
    * add
    * edit
        * by email
        * by email md5
    * change email
    * delete 
        * by id
        * by email
    * get information
        * short
        * long
        * full
* transactionals
    * send
