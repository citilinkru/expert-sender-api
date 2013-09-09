expert-sender-api
=================

Simple API for expert sender service

## Usage

    $expertSender = new ExpertSender('', $apiKey);

    $customProperty = new Property(1775, ExpertSenderEnum::TYPE_STRING, 'female')
    $result = $expertSender->addUserToList('my@mail.com', $listId, [$customProperty], 'My name');

    if ($result->isOk()) {
        ...
    } else {
        ...
    }

## Implemented functions

* addUserToList
* deleteUser