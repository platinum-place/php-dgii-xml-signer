# PHP DGII XML Signer

[![Latest Version on Packagist](https://img.shields.io/packagist/v/platinum-place/php-dgii-xml-signer.svg?style=flat-square)](https://packagist.org/packages/platinum-place/php-dgii-xml-signer)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Total Downloads](https://img.shields.io/packagist/dt/platinum-place/php-dgii-xml-signer.svg?style=flat-square)](https://packagist.org/packages/platinum-place/php-dgii-xml-signer)

Librería PHP diseñada para el firmado digital de documentos XML siguiendo los estándares de la **Dirección General de Impuestos Internos (DGII)** de la República Dominicana para el sistema de **Comprobantes Fiscales Electrónicos (e-CF)**.

Este paquete actúa como un wrapper especializado sobre `selective/xmldsig`, aplicando las normalizaciones específicas (C14N) requeridas por la DGII.

## Características

- ✅ Firma digital XML según estándares **XMLDSig**.
- ✅ Normalización **C14N** específica para cumplimiento con validadores de la DGII.
- ✅ Soporte para certificados `.p12` emitidos por entidades autorizadas.
- ✅ Alias de métodos (`sign()` y `sing()`) para compatibilidad con estándares y documentación oficial.
- ✅ Gestión de errores mediante excepciones personalizadas.
- ✅ Soporte para entornos modernos con **OpenSSL 3+**.

## Requisitos

- **PHP:** 8.1 o superior.
- **Extensiones:** `openssl`, `dom`, `xmlwriter`.
- **Certificado:** Archivo `.p12` válido y su respectiva contraseña.

## Instalación

```bash
composer require platinum-place/php-dgii-xml-signer
```

## Uso Básico

```php
use PlatinumPlace\DgiiXmlSigner\SignManager;
use PlatinumPlace\DgiiXmlSigner\Exception\DgiiXmlSignerException;

try {
    $manager = new SignManager();
    $p12Content = file_get_contents('ruta/al/certificado.p12');
    $password = 'tu_contraseña';
    $xmlContent = '...'; // Tu XML de e-CF

    // Puedes usar sign() (estándar PSR) o sing() (nomenclatura DGII)
    $signedXml = $manager->sign($p12Content, $password, $xmlContent);
    
    file_put_contents('comprobante_firmado.xml', $signedXml);
} catch (DgiiXmlSignerException $e) {
    echo "Error de firma: " . $e->getMessage();
}
```

## Configuración Especial (OpenSSL 3+)

Los certificados de la DGII suelen utilizar cifrados antiguos (RC2-40-CBC). En sistemas modernos (como Ubuntu 22.04+, PHP 8.2+), OpenSSL puede rechazar estos certificados a menos que se habilite el proveedor **Legacy**.

### Habilitar proveedor Legacy en `openssl.cnf`

1. Edite su archivo de configuración (usualmente `/etc/ssl/openssl.cnf`).
2. Asegúrese de activar las siguientes secciones:

```ini
[provider_sect]
default = default_sect
legacy = legacy_sect

[default_sect]
activate = 1

[legacy_sect]
activate = 1
```

Para más detalles, consulte este [hilo de Stack Overflow](https://stackoverflow.com/questions/72859711/convert-an-old-style-p12-to-pem-unsupported-algorithm-rc2-40-cbc).

## Pruebas (Testing)

El paquete incluye una suite de pruebas con PHPUnit para asegurar el correcto funcionamiento.

```bash
composer test
```

Para ejecutar pruebas funcionales con un certificado real, coloque su archivo en `tests/Fixtures/test_cert.p12` y configure la contraseña en `tests/SignManagerTest.php`. Consulte [TESTING.md](TESTING.md) para más detalles.

## Calidad de Código

Mantenemos altos estándares de calidad utilizando herramientas de análisis estático y formato automático:

- **Formato (PHP-CS-Fixer):** `composer lint`
- **Análisis Estático (PHPStan):** `composer analyze`

## Seguridad

Si descubre alguna vulnerabilidad de seguridad, por favor envíe un correo electrónico a seguridad@platinumplace.do en lugar de utilizar el rastreador de issues público.

## Contribuciones

¡Las contribuciones son bienvenidas! Por favor, lea nuestra [Guía de Contribución](CONTRIBUTING.md) para conocer el proceso y los estándares de desarrollo.

## Créditos

- Basado en la librería [selective/xmldsig](https://github.com/selective-php/xmldsig).
- Inspirado en las especificaciones técnicas de la [DGII](https://dgii.gov.do/facturacionElectronica).

## Licencia

Este proyecto está licenciado bajo la Licencia MIT. Consulte el archivo [LICENSE](LICENSE) para más información.
