Expert Sender Api
=================

Simple API for expert sender service

## Usage

```php
$expertSender = new ExpertSender('https://api.esv2.com/', $apiKey);

$customProperty = new Property(1775, ExpertSenderEnum::TYPE_STRING, 'female')
$result = $expertSender->addUserToList('my@mail.com', $listId, [$customProperty], 'My name');

if ($result->isOk()) {
    ...
} else {
    ...
}
```

## Implemented functions

* addUserToList
* deleteUser