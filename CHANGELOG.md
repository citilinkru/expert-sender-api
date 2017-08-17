# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).
## [Unreleased]
### Added
- ```ErrorMessage::__toString()```
## [1.1.0] - 2017-08-17
### Added
- feature to subscribe to new event "expert_sender_api.request.exception_thrown"
### Changed
- changed empty text of error message to more informative

## [1.0.0] - 2017-08-16
### Added
- phpstan lvl 7 checks
- symfony/event-dispatcher ^3.0.0 requirement
- optional feature to listen events from RequestSender
- api method to add/get/delete/edit rows in tables
- send trigger message api method
- CsvReader class and used it in SpecificCsvMethodResponse
- new method SubscribersResource::getRemovedSubscribers instead of RemovedSubscribersResource::get
- new method ExpertSenderApi::getServerTime instead of TimeResource::get
- new method MessagesResource::sendTransactionalMessage instead of TransactionalsResource::send
- new method ExpertSenderApi::getBouncesList instead of BouncesResource::get
### Removed
- all deprecated features
### Changed
- renamed SortOrder into Direction and moved in Citilink\ExpertSenderApi\Enum\DataTablesGetDataPostRequest namespace
- moved Operator in Citilink\ExpertSenderApi\Enum\DataTablesGetDataPostRequest
- changed argument type for ExpertSenderApi from RequestSender to RequestSenderInterface

## [0.4.0] - 2017-08-09
Fully refactored library, changed everything
### Added 
- Bounces resource
- Removed subscriber resource
- Subscribers resource
- Time resource
- Transactionals resource
### Changed
- moved all files to new namespace
- increased min version of PHP to 7.1
- change name of package and authors
### Deprecated
- all chunks
- all old classes, that was'not refactored yet
