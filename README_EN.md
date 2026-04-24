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

## 🛠️ Credits and Technical Base

This project is directly based on the specifications of the **[Instructivo sobre Facturación Electrónica: Firmado de e-CF](https://dgii.gov.do/cicloContribuyente/facturacion/comprobantesFiscalesElectronicosE-CF/Documentacin%20sobre%20eCF/Instructivos%20sobre%20Facturaci%C3%B3n%20Electr%C3%B3nica/Firmado%20de%20e-CF.pdf)** published by the **DGII**.

For the technical implementation, we use the **[selective/xmldsig](https://github.com/selective-php/xmldsig)** library as a base. This library is the one recommended (and illustrated) by the DGII in its technical manuals for PHP developers. However, to achieve successful validation on official servers, manual adjustments are required that are not explicitly detailed in the general documentation.

---

## ⚠️ Important Clarifications

Although the DGII documentation provides examples, there are critical implementation details in the base library that must be adjusted for the XML to be accepted.

### Case 1: Modifications to `XmlSigner.php`

According to the DGII manual, it is imperative to modify the `XmlSigner.php` class from the `selective/xmldsig` library to force a canonicalization without comments.

1. **General Canonicalization Adjustment:**
   In the `XmlSigner` class, you must ensure that the `C14N` method is called with the correct parameters to exclude comments:
   ```php
   // Change from:
   $canonicalData = $element->C14N(true, false);
   // To:
   $canonicalData = $element->C14N(false, false);
   ```

2. **Adjustment in `SignedInfo` (Approx. Line 179):**
   For the signature of the `SignedInfo` block, even stricter normalization is required:
   ```php
   // Change from:
   $c14nSignedInfo = $signedInfoElement->C14N(true, false);
   // To:
   $c14nSignedInfo = $signedInfoElement->C14N();
   ```

**Note:** This package already includes these corrections applied natively in its own `XmlSigner` class, so you don't need to modify anything in your `vendor` folder.

### Case 2: OpenSSL Compatibility (RC2-40-CBC Error)

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

## 📚 Additional Resources

- **[Official DGII Documentation - Electronic Invoicing](https://dgii.gov.do/cicloContribuyente/facturacion/comprobantesFiscalesElectronicosE-CF/Paginas/documentacionSobreE-CF.aspx)**: Main portal with all regulations and technical documentation.
- **[e-CF Signing Instruction (PDF)](https://dgii.gov.do/cicloContribuyente/facturacion/comprobantesFiscalesElectronicosE-CF/Documentacin%20sobre%20eCF/Instructivos%20sobre%20Facturaci%C3%B3n%20Electr%C3%B3nica/Firmado%20de%20e-CF.pdf)**: Detailed technical guide on the digital signature process.
- **[Base Library: selective/xmldsig](https://github.com/selective-php/xmldsig)**: Repository of the library used as the signature engine.

---

## ⚖️ License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for more details.
