# Testing Guide - DGII XML Signer

This document explains how to perform tests in the package to ensure that signing works correctly.

## Requirements
- Composer installed.
- Dependencies installed: \`composer install\`.
- \`openssl\` extension enabled in PHP.

## How to run tests
To run all tests, use the following command from the project root:

\`\`\`bash
./vendor/bin/phpunit
\`\`\`

## Testing with Real Certificates
To test the signing process with a real certificate (.p12) without affecting production code:

1.  Place your certificate in \`tests/Fixtures/your_certificate.p12\`.
2.  Open the \`tests/SignManagerTest.php\` file.
3.  In the \`test_functional_signature_process\` method, update:
    -   The certificate file name.
    -   The certificate **password** (\`$password\` variable).
4.  Run \`./vendor/bin/phpunit\` again.

## Troubleshooting (OpenSSL 3+)
If you receive an error saying the certificate could not be read, you probably need to enable **Legacy** mode in OpenSSL, as DGII certificates often use old ciphers (RC2-40-CBC).

Refer to the \`README.md\` file for detailed configuration steps on your operating system.
