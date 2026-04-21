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

## Aclaraciones

Aunque la documentación de la DGII explica cómo utilizar la librería **XMLDSIG** para leer los certificados, y esta aplicación está basada en esa documentación, destaco que, por lo menos para mí, hay una parte de la documentación que no está del todo clara.

A continuación, muestro algunos casos:

### Caso 1: Cambiar la clase `XmlSigner.php` (o hacer una copia de la misma con los cambios de lugar)

Uno de estos casos se encuentra en la parte sobre la siguiente línea de código:

```php
$canonicalData = $element->C14N(true, false);
```

Debería cambiarse a:

```php
$canonicalData = $element->C14N(false, false);
```

Si bien la documentación explica que se debe cambiar esta línea, no menciona que también es necesario realizar el mismo cambio en otra parte del archivo:

```php
$c14nSignedInfo = $signedInfoElement->C14N(true, false);
```

Debería cambiarse a:

```php
$c14nSignedInfo = $signedInfoElement->C14N();
```

Este cambio debe realizarse específicamente en la línea 179 del archivo original.

### Caso 2: Error al leer el certificado

La documentación menciona que la librería fue probada en PHP versiones 8.1.12 y 8.1.13, si utilizas el paquete en una version mas reciente, como 8.4 o 8.5, la validación falla debido a que el cifrado RC2-40-CBC utilizado en los archivos .p12 cambió en las versiones más recientes de OpenSSL, que normalmente vienen con PHP 8.2 en adelante.

Para solucionarlo, debemos modificar el archivo `openssl.cnf` para que admita el cifrado que necesitamos, cambiando la configuración por defecto al modo "legacy".

#### Habilitar cifrado "legacy"

1. Edita el archivo `openssl.cnf` con el siguiente comando:
   ```bash
   sudo nano /etc/ssl/openssl.cnf
    ```

2. Busca la sección [default_sect] y cámbiarla a:
   ```bash
    [default_sect]
    activate = 1
    ```

3. Luego, busca la sección [legacy_sect] y cámbiarla a:
   ```bash
    [legacy_sect]
    activate = 1
    ```

4. Por último, busca la sección [provider_sect] y cámbiarla a:
   ```bash
    [provider_sect]
    default = default_sect
    legacy = legacy_sect
    ```

5.  Finalmente, guardar los cambios, salir del archivo y reiniciar el entorno.

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
