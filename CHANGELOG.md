# Changelog
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## [Unreleased]
### Added
- added symfony/event-dispatcher ^3.0.0 requirement
- added optional feature to listen events from RequestSender
### Changed
- changed argument type for ExpertSenderApi from RequestSender to RequestSenderInterface
### Deprecated
- method SubscriberInfo::addPropertyChunk is deprecated, use SubscriberInfo::addProperty instead
- method SpecificCsvMethodResponse::getCsvLinesWithoutHeader is deprecated, use SpecificCsvMethodResponse::getCsvReader instead

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
