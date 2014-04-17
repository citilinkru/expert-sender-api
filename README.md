Expert Sender Api
=================

Simple API for expert sender service

## Usage

```php
$expertSender = new ExpertSender('https://api.esv2.com/', $apiKey);

$customProperty = new Property(1775, ExpertSenderEnum::TYPE_STRING, 'female');

$request = new AddUserToListRequest();
$request
    ->setEmail('my@email.com')
    ->setListId(1000)
    ->setFirstName('my name');
    ->addProperty($customProperty)
    ->freeze();

$result = $expertSender->addUserToList($request);

if ($result->isOk()) {
    ...
} else {
    ...
}
```

## Implemented functions

* addUserToList
* deleteUser
* getUserId
* addTableRow
* getTableData
* updateTableRow
* deleteTableRow
* changeEmail
* sendTrigger
* sendTransactional