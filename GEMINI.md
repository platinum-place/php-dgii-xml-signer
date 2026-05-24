# PHP DGII XML Signer - Guía de Desarrollo (Contexto para IA)

Este archivo es la fuente central de verdad para la arquitectura, convenciones y especificaciones técnicas de este proyecto. Está diseñado para ser leído y respetado rigurosamente por **desarrolladores humanos** y **Agentes de IA** (Gemini, Cursor, Copilot).

---

## 🚀 Descripción del Proyecto

Este paquete implementa el estándar **XMLDSig** con adaptaciones técnicas críticas en el proceso de canonicalización (C14N) y firmas de la DGII (Dirección General de Impuestos Internos de la República Dominicana) para asegurar que los comprobantes fiscales electrónicos (e-CF) sean aceptados por sus servidores de validación.

### Tecnologías Principales
- **PHP 8.1+**
- **Librería Base:** `selective/xmldsig` (adaptada internamente).
- **OpenSSL:** Para lectura de certificados y claves privadas `.p12` o `.pfx`.

### Referencias Oficiales y Contexto
- **Manuales Técnicos Oficiales:** Consulta la documentación técnica en [docs/GEMINI.md](file:///Users/warlyn/PhpstormProjects/php-dgii-xml-signer/docs/GEMINI.md).
- **[Documentación sobre e-CF (DGII)](https://dgii.gov.do/cicloContribuyente/facturacion/comprobantesFiscalesElectronicosE-CF/Paginas/documentacionSobreE-CF.aspx)**
- **[Instructivo de Firmado de e-CF (PDF)](https://dgii.gov.do/cicloContribuyente/facturacion/comprobantesFiscalesElectronicosE-CF/Documentacin%20sobre%20eCF/Instructivos%20sobre%20Facturaci%C3%B3n%20Electr%C3%B3nica/Firmado%20de%20e-CF.pdf)**

---

## 🏗️ Arquitectura del Repositorio

El paquete mantiene una estructura simplificada y optimizada:

- **[src/SignManager.php](file:///Users/warlyn/PhpstormProjects/php-dgii-xml-signer/src/SignManager.php):** El punto de entrada principal para el cliente. Proporciona los siguientes métodos públicos:
  - `sign()` / `sing()`: Firma un XML digitalmente utilizando un certificado y contraseña.
  - `validateCertificate()`: Valida y extrae claves del archivo de certificado `.p12` / `.pfx`.
  - `verifyXmlSignature()`: Valida y verifica que la firma de un XML firmado sea íntegra y cumpla con las especificaciones.
- **[src/XmlSigner.php](file:///Users/warlyn/PhpstormProjects/php-dgii-xml-signer/src/XmlSigner.php):** Sobrescribe e implementa los comportamientos específicos de la canonicalización y firmado XMLDSig exigidos por la DGII.
- **[src/XmlSignatureVerifier.php](file:///Users/warlyn/PhpstormProjects/php-dgii-xml-signer/src/XmlSignatureVerifier.php):** Realiza la verificación técnica de firmas en documentos e-CF firmados, aplicando la misma rigurosidad de C14N que el firmador.

> [!NOTE]
> **Cambios Recientes de Simplificación:**
> - Se eliminó la clase de excepción personalizada `src/Exception/DgiiXmlSignerException.php`. En su lugar, el paquete utiliza `\RuntimeException` o la excepción nativa de la librería base `Selective\XmlDSig\Exception\XmlSignatureValidatorException`.
> - Se eliminaron los fixtures y archivos de pruebas unitarias (`tests/SignManagerTest.php`) para mantener la librería ligera. Se mantiene `tests/.gitkeep`.
> - Toda la documentación oficial de la DGII se organizó directamente bajo el directorio [docs/](file:///Users/warlyn/PhpstormProjects/php-dgii-xml-signer/docs/).

---

## 🤖 Directrices Críticas para Agentes de IA

Si eres una IA modificando o trabajando en este repositorio, debes cumplir **ESTRICTAMENTE** con las siguientes directrices técnicas:

### 1. Reglas Técnicas de Canonicalización (C14N)
- **Canonicalización sin comentarios:** La DGII exige Inclusive C14N sin comentarios. Por lo tanto, al llamar al método `$element->C14N()` o `$signedInfoElement->C14N()`, **NUNCA** utilices parámetros que dejen comentarios habilitados (usa `C14N(false, false)` o simplemente `C14N()` que por defecto deshabilita comentarios).
- **Manejo de Espacios en Blanco:** Al instanciar `DOMDocument` para procesar XML (firmar o verificar), debes establecer la propiedad `preserveWhiteSpace = false` y `formatOutput = false` para evitar alteraciones de hash por formateo e indentación.
- **Verificación sin Re-parseo:** En `XmlSignatureVerifier::verifyDocument`, al verificar `SignedInfo`, **NO** vuelvas a parsear la data canonicalizada a través de un nuevo DOMDocument con `preserveWhiteSpace = true` o `formatOutput = true`, ya que introduce discrepancias de espacios en blanco que invalidan la firma. Valida directamente la salida directa de `$signedInfoNode->C14N()`.
- **Estructura `<KeyInfo>` Simplificada:** Durante el firmado (`XmlSigner::appendSignature`), los elementos `<KeyValue>`, `<RSAKeyValue>`, `<Exponent>`, etc. no deben incluirse en el XML de firma, ya que no son requeridos por la DGII. Solo debe incluirse la estructura `<X509Data>` conteniendo los certificados `<X509Certificate>`.

### 2. Estilo de Código y Documentación
- **DocBlocks (Comentarios de Código):** Deben escribirse siempre en **Inglés** (ej. estándares PSR, parámetros, excepciones).
- **Comentarios Arquitectónicos y Soporte Técnico:** Los comentarios explicativos dentro del código que hablen sobre requerimientos DGII, bugs conocidos de OpenSSL o notas para otros desarrolladores de la comunidad hispana deben escribirse en **Español**.

### 3. Compatibilidad con OpenSSL Legacy
- El paquete debe asegurar compatibilidad con la configuración de OpenSSL "legacy" (necesaria para leer ciertos certificados antiguos cifrados en RC2-40-CBC bajo versiones recientes de PHP/OpenSSL).

---

## 🛠️ Comandos de Desarrollo

```bash
# Ejecutar pruebas del proyecto (PHPUnit)
composer test

# Corregir el estilo del código según PHP-CS-Fixer
composer lint

# Ejecutar el análisis estático de código (PHPStan)
composer analyze
```

---
*Este archivo sirve como fuente central de verdad para la IA. Manténgalo actualizado ante cambios arquitectónicos.*
