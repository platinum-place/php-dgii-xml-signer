# Changelog

All notable versions of this project will be documented in this file following the [Keep a Changelog](https://keepachangelog.com/en/1.0.0/) format and complying with [Semantic Versioning](https://semver.org/).

## [1.3.1] - 2026-05-24
### Added
- `XmlSignatureVerifier` class to support technical verification of e-CF XMLDSig signatures.
- `verifyXmlSignature` method in `SignManager` as the public API for signature validation.

### Changed
- Simplified package exception handling by removing `DgiiXmlSignerException` in favor of standard PHP `RuntimeException` and library-specific exceptions.
- Consolidated and cleaned up project documentation, moving all files from `docs/dgii/` directly to `docs/`.
- Removed English README (`README_EN.md`) to maintain a single Spanish version.
- Cleared outdated unit/functional tests and fixtures to keep the library lightweight, leaving `tests/.gitkeep` for future setups.
- Updated root `GEMINI.md` with detailed guidelines and critical C14N rules for AI developer assistants.

## [1.3.0] - 2026-05-24
### Changed
- Standardized documentation for AI and human developers.

## [1.2.0] - 2026-05-24
### Added
- Public `validateCertificate` method in `SignManager` to allow external certificate validation.

## [1.1.0] - 2026-04-17
### Changed
- Standards and documentation improvements.
- DocBlocks translated to English.
- README converted to bilingual format.
- All technical documentation moved to English.

## [1.0.0] - 2024-05-15
### Added
- `SignManager` class as the main entry point for signing.
- Custom `XmlSigner` implementation to comply with DGII C14N normalization.
- `sign()` method alias for better compatibility with PSR standards.
- Support for OpenSSL "Legacy" configuration in modern environments.
- Custom exception `DgiiXmlSignerException`.
- Unit and functional tests for the signing process.
- Full code documentation (DocBlocks) following PSR-5 standards.
- Contribution guide and professional development workflow.
- Code quality scripts with PHP-CS-Fixer and PHPStan.
