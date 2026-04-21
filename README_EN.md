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

## Clarifications

Although the DGII documentation explains how to use the **XMLDSIG** library to read certificates, and this application is based on that documentation, I would like to point out that, at least for me, there is a part of the documentation that is not entirely clear.

Below, I’ll show some examples:

### Case 1: Modifying the `XmlSigner.php` class (or creating a copy of it with the changes in place)

One such example is found in the section regarding the following line of code:

```php
$canonicalData = $element->C14N(true, false);
```

It should be changed to:

```php
$canonicalData = $element->C14N(false, false);
```

Although the documentation explains that this line must be changed, it does not mention that the same change must also be made in another part of the file:

```php
$c14nSignedInfo = $signedInfoElement->C14N(true, false);
```

It should be changed to:

```php
$c14nSignedInfo = $signedInfoElement->C14N();
```

This change must be made specifically on line 179 of the original file.

### Case 2: Error reading the certificate

The documentation mentions that the library was tested on PHP versions 8.1.12 and 8.1.13, but if you use the package in a newer version, such as 8.4 or 8.5, validation fails because the RC2-40-CBC cipher used in .p12 files has changed in newer versions of OpenSSL, which typically come with PHP 8.2 and later.

To fix this, we must modify the `openssl.cnf` file to support the cipher that

#### Enable “legacy” encryption

1. Edit the `openssl.cnf` file using the following command:
   ```bash
   sudo nano /etc/ssl/openssl.cnf
    ```

2. Find the [default_sect] section and change it to:
   ```bash
    [default_sect]
    activate = 1
    ```

3. Next, find the [legacy_sect] section and change it to:
   ```bash
    [legacy_sect]
    activate = 1
    ```

4. Finally, find the [provider_sect] section and change it to:
   ```bash
    [provider_sect]
    default = default_sect
    legacy = legacy_sect
    ```

5.  Finally, save the changes, exit the file, and restart the environment.

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
