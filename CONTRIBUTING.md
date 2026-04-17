# Contribution Guide

Thank you for considering contributing to **PHP DGII XML Signer**! All help is welcome to keep this tool updated with DGII standards.

## Development Process

To contribute, follow these steps:

1.  **Fork** the repository.
2.  Create a branch for your feature or fix (\`git checkout -b feature/new-improvement\`).
3.  Install dependencies: \`composer install\`.
4.  Make your changes ensuring you follow code standards (PSR-12).
5.  **Run tests**: Ensure everything is still working with \`composer test\`.
6.  **Verify code quality**:
    -   Formatting: \`composer lint\` (we use PHP-CS-Fixer).
    -   Static Analysis: \`composer analyze\` (we use PHPStan).
7.  **Commit** your changes following [Conventional Commits](https://www.conventionalcommits.org/).
8.  **Push** to your branch and open a **Pull Request**.

## Code Standards

We use **PHP-CS-Fixer** to maintain a consistent code style following the PSR-12 standard. Please run \`composer lint\` before submitting any changes.

## Testing

If you add new functionality, please include its respective tests in the \`tests/\` folder. Pull Requests that reduce current test coverage or introduce failures in existing tests will not be accepted.

## Error Reporting

If you find a bug, please open an *Issue* on GitHub detailing:
-   PHP version.
-   Library version.
-   Steps to reproduce the error.
-   The error obtained (logs or exception messages).

---

Thank you for helping the electronic invoicing community in the Dominican Republic!
