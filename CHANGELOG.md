# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [0.0.2] - 2019-07-04

### Added

- Changelog
- Full i18n support. Plugin translations for PHP and JS can be generated with `yarn pot`.
- Dedicated class for booting framework.
- Dedicated class for error handling on boot.

### Changed

- Removed trailing commas from function calls that used them, so as to broaden compatibility.
  This is the only [new feature from PHP 7.3](https://wiki.php.net/rfc/trailing-comma-function-calls) that was being utilized.
- Formatting improvements.

[0.0.2]: https://github.com/pixelcollective/copernicus/compare/v0.1.0...v0.0.2
[0.0.1]: https://github.com/pixelcollective/copernicus/compare/v0.1.0...v0.1.0
