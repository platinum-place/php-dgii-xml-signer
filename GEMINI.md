# PHP DGII XML Signer - Development Guide

Specialized PHP library for digital signing of XML documents according to **DGII** (Dominican Republic) standards.

## 🚀 Project Overview

This package implements the **XMLDSig** standard with critical customizations in the canonicalization (C14N) process to ensure that the signature is accepted by DGII servers.

### Core Technologies
- **PHP 8.1+**
- **Base Library:** \`selective/xmldsig\`.
- **OpenSSL:** For certificate and private key reading.

## 🏗️ Architecture

- **\`SignManager\`:** Simplified entry point for the user.
- **\`XmlSigner\`:** Core class that overrides base library behaviors to comply with DGII.
- **\`Exception/\`:** Custom exceptions for the signing domain.

## 🛠️ Development Commands

\`\`\`bash
# Run tests (PHPUnit)
composer test

# Fix code style (PHP-CS-Fixer)
composer lint

# Static analysis (PHPStan)
composer analyze
\`\`\`

## 📝 Development Conventions

1.  **DocBlocks:** All source code must be documented using DocBlocks in **English**.
2.  **Canonicalization:** Any changes in \`XmlSigner::signDocument\` or \`XmlSigner::appendSignature\` must be validated against the official DGII schema, as normalization is extremely sensitive.
3.  **Certificates:** Ensure compatibility with OpenSSL "legacy" configuration if required for certain \`.p12\` certificates.

---
*This file serves as context for Gemini CLI. Keep it updated upon architectural changes.*
