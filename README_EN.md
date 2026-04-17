# PHP DGII XML Signer 🇩🇴

[![Latest Version on Packagist](https://img.shields.io/packagist/v/platinum-place/php-dgii-xml-signer.svg?style=flat-square)](https://packagist.org/packages/platinum-place/php-dgii-xml-signer)
[![Total Downloads](https://img.shields.io/packagist/dt/platinum-place/php-dgii-xml-signer.svg?style=flat-square)](https://packagist.org/packages/platinum-place/php-dgii-xml-signer)
[![GitHub License](https://img.shields.io/github/license/platinum-place/php-dgii-xml-signer.svg?style=flat-square)](LICENSE)

Specialized XML Signer designed to comply with **Electronic Invoicing (e-CF)** standards from the **General Directorate of Internal Taxes (DGII)** in the Dominican Republic.

> [Leer en Español 🇪🇸](./README.md)

---

## 🚀 Features

- **XMLDSig Standard:** Robust implementation based on `selective/xmldsig`.
- **Special Canonicalization:** Technical adjustments in C14N normalization required by the official DGII validator.
- **Certificate Support:** Compatible with `.p12` and `.pfx` files.
- **Lightweight:** Designed for easy integration into any PHP project or framework (Laravel, Symfony, etc.).

---

## 🛠️ Installation

```bash
composer require platinum-place/php-dgii-xml-signer
```

---

## 📖 Quick Usage

```php
use PlatinumPlace\DgiiXmlSigner\SignManager;

$signer = new SignManager();

// Read the certificate
$certContent = file_get_contents('path/to/certificate.p12');
$password = 'your_password';

// XML to sign
$xml = '<root>...</root>';

// Sign
$signedXml = $signer->sign($certContent, $password, $xml);

file_put_contents('signed_invoice.xml', $signedXml);
```

---

## 🙋‍♂️ Support and Consulting

If you need technical assistance with the implementation of this package or have general questions about the **Electronic Invoicing ecosystem in the Dominican Republic**, feel free to contact me.

I offer specialized consulting services for companies seeking to certify their systems with the DGII.

- **Contact:** My updated contact methods are available on my **[GitHub Profile](https://github.com/warlyn)**.
- **Issues:** For package bugs, please open an issue in this repository.

---

## ⚖️ License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for more details.
