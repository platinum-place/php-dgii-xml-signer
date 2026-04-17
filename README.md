# PHP DGII XML Signer 🇩🇴

[![Latest Version on Packagist](https://img.shields.io/packagist/v/platinum-place/php-dgii-xml-signer.svg?style=flat-square)](https://packagist.org/packages/platinum-place/php-dgii-xml-signer)
[![Total Downloads](https://img.shields.io/packagist/dt/platinum-place/php-dgii-xml-signer.svg?style=flat-square)](https://packagist.org/packages/platinum-place/php-dgii-xml-signer)
[![GitHub License](https://img.shields.io/github/license/platinum-place/php-dgii-xml-signer.svg?style=flat-square)](LICENSE)

Firmador de XML especializado para cumplir con los estándares de **Facturación Electrónica (e-CF)** de la **Dirección General de Impuestos Internos (DGII)** en la República Dominicana.

> [Read in English 🇺🇸](./README_EN.md)

---

## 🚀 Características

- **Estándar XMLDSig:** Implementación robusta basada en `selective/xmldsig`.
- **Canonicalización Especial:** Ajustes técnicos en la normalización C14N requeridos por el validador oficial de la DGII.
- **Soporte Certificados:** Compatible con archivos `.p12` y `.pfx`.
- **Ligero:** Diseñado para ser integrado fácilmente en cualquier proyecto PHP o framework (Laravel, Symfony, etc.).

---

## 🛠️ Instalación

```bash
composer require platinum-place/php-dgii-xml-signer
```

---

## 📖 Uso rápido

```php
use PlatinumPlace\DgiiXmlSigner\SignManager;

$signer = new SignManager();

// Leer el certificado
$certContent = file_get_contents('path/to/certificate.p12');
$password = 'tu_password';

// XML a firmar
$xml = '<root>...</root>';

// Firmar
$signedXml = $signer->sign($certContent, $password, $xml);

file_put_contents('signed_invoice.xml', $signedXml);
```

---

## 🙋‍♂️ Soporte y Consultoría

Si necesitas asistencia técnica con la implementación de este paquete o tienes dudas generales sobre el ecosistema de **Facturación Electrónica en la República Dominicana**, puedes contactarme directamente.

Ofrezco servicios de consultoría especializada para empresas que buscan certificar sus sistemas ante la DGII.

- **Contacto:** Mis métodos de contacto actualizados están disponibles en mi **[Perfil de GitHub](https://github.com/warlyn)**.
- **Issues:** Para errores del paquete, por favor abre un issue en este repositorio.

---

## ⚖️ Licencia

Este proyecto está bajo la Licencia MIT. Consulta el archivo [LICENSE](LICENSE) para más detalles.
