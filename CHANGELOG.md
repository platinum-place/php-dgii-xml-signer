# Changelog

All notable versions of this project will be documented in this file following the [Keep a Changelog](https://keepachangelog.com/en/1.0.0/) format and complying with [Semantic Versioning](https://semver.org/).

## [1.1.0] - 2026-04-17
### Changed
- Standards and documentation improvements.
- DocBlocks translated to English.
- README converted to bilingual format.
- All technical documentation moved to English.

## [1.0.0] - 2024-05-15
### Added
- \`SignManager\` class as the main entry point for signing.
- Custom \`XmlSigner\` implementation to comply with DGII C14N normalization.
- \`sign()\` method alias for better compatibility with PSR standards.
- Support for OpenSSL "Legacy" configuration in modern environments.
- Custom exception \`DgiiXmlSignerException\`.
- Unit and functional tests for the signing process.
- Full code documentation (DocBlocks) following PSR-5 standards.
- Contribution guide and professional development workflow.
- Code quality scripts with PHP-CS-Fixer and PHPStan.
