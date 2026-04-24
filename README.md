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

## 🛠️ Créditos y Base Técnica

Este proyecto se basa directamente en las especificaciones del **[Instructivo sobre Facturación Electrónica: Firmado de e-CF](https://dgii.gov.do/cicloContribuyente/facturacion/comprobantesFiscalesElectronicosE-CF/Documentacin%20sobre%20eCF/Instructivos%20sobre%20Facturaci%C3%B3n%20Electr%C3%B3nica/Firmado%20de%20e-CF.pdf)** publicado por la **DGII**.

Para la implementación técnica, utilizamos como base la librería **[selective/xmldsig](https://github.com/selective-php/xmldsig)**. Esta librería es la recomendada (e ilustrada) por la DGII en sus manuales para desarrolladores PHP. Sin embargo, para lograr una validación exitosa en los servidores oficiales, es necesario realizar ajustes manuales que no están detallados de forma explícita en la documentación general.

---

## ⚠️ Aclaraciones Importantes

Aunque la documentación de la DGII proporciona ejemplos, existen detalles críticos en la implementación de la librería base que deben ajustarse para que el XML sea aceptado.

### Caso 1: Modificaciones en `XmlSigner.php`

Según el instructivo de la DGII, es imperativo modificar la clase `XmlSigner.php` de la librería `selective/xmldsig` para forzar una canonicalización sin comentarios.

1. **Ajuste de Canonicalización General:**
   En la clase `XmlSigner`, se debe asegurar que el método `C14N` se llame con los parámetros correctos para excluir comentarios:
   ```php
   // Cambiar de:
   $canonicalData = $element->C14N(true, false);
   // A:
   $canonicalData = $element->C14N(false, false);
   ```

2. **Ajuste en `SignedInfo` (Línea 179 aprox.):**
   Para la firma del bloque `SignedInfo`, se requiere una normalización aún más estricta:
   ```php
   // Cambiar de:
   $c14nSignedInfo = $signedInfoElement->C14N(true, false);
   // A:
   $c14nSignedInfo = $signedInfoElement->C14N();
   ```

**Nota:** Este paquete ya incluye estas correcciones aplicadas de forma nativa en su clase `XmlSigner`, por lo que no necesitas modificar nada en tu carpeta `vendor`.

### Caso 2: Compatibilidad con OpenSSL (Error RC2-40-CBC)

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

## 📚 Recursos Adicionales

- **[Documentación Oficial DGII - Facturación Electrónica](https://dgii.gov.do/cicloContribuyente/facturacion/comprobantesFiscalesElectronicosE-CF/Paginas/documentacionSobreE-CF.aspx)**: Portal principal con toda la normativa y documentación técnica.
- **[Instructivo de Firmado de e-CF (PDF)](https://dgii.gov.do/cicloContribuyente/facturacion/comprobantesFiscalesElectronicosE-CF/Documentacin%20sobre%20eCF/Instructivos%20sobre%20Facturaci%C3%B3n%20Electr%C3%B3nica/Firmado%20de%20e-CF.pdf)**: Guía técnica detallada sobre el proceso de firma digital.
- **[Librería Base: selective/xmldsig](https://github.com/selective-php/xmldsig)**: Repositorio de la librería utilizada como motor de firma.

---

## ⚖️ Licencia

Este proyecto está bajo la Licencia MIT. Consulta el archivo [LICENSE](LICENSE) para más detalles.
