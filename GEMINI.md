# GEMINI Project Context: PHP DGII XML Signer

## Project Overview
Esta es una librería PHP (`platinum-place/php-dgii-xml-signer`) diseñada para firmar digitalmente documentos XML siguiendo los estándares **XMLDSig**, específicamente para el sistema de **Comprobantes Fiscales Electrónicos (e-CF)** de la **Dirección General de Impuestos Internos (DGII)** de la República Dominicana.

La librería actúa como un wrapper especializado sobre `selective/xmldsig`, aplicando personalizaciones necesarias para cumplir con los requerimientos técnicos de la DGII (como la normalización C14N específica).

### Tech Stack
- **PHP:** 8.1 o superior.
- **Dependencias principales:** `selective/xmldsig`.
- **Extensiones PHP requeridas:** `openssl`, `dom`, `xmlwriter`.
- **Testing:** PHPUnit.

---

## Building and Running

### Setup
Para instalar las dependencias del proyecto:
```bash
composer install
```

### Testing
Para ejecutar las pruebas unitarias:
```bash
composer test
# O directamente
./vendor/bin/phpunit
```
*Nota: Actualmente `tests/SignManagerTest.php` existe pero no contiene casos de prueba implementados.*

---

## Development Conventions

### Estructura de Archivos
- `src/`: Contiene la lógica principal.
    - `SignManager.php`: Punto de entrada principal para el firmado.
    - `XmlSigner.php`: Implementación personalizada del firmador XMLDSig.
- `tests/`: Pruebas unitarias (PSR-4 `PlatinumPlace\DgiiXmlSigner\Tests\`).

### Observaciones Técnicas Importantes
1. **Configuración de OpenSSL:** En entornos modernos (OpenSSL 3+), los certificados `.p12` antiguos de la DGII pueden requerir la habilitación del proveedor **legacy** en `openssl.cnf`.
2. **Normalización C14N:** La implementación en `XmlSigner.php` utiliza `$element->C14N()` sin parámetros (equivalente a `false, false`) para cumplir con la documentación de la DGII.
3. **Gestión de Errores:** Se utiliza `DgiiXmlSignerException` para manejar errores de lectura de certificados o fallos en el proceso de firma, eliminando el uso de `exit`.
4. **Nomenclatura:** Se ha añadido el método `sign()` como alias de `sing()` para mayor compatibilidad con estándares de codificación, manteniendo `sing()` para alineación con la documentación de la DGII.

---

## Usage Example
```php
use PlatinumPlace\DgiiXmlSigner\SignManager;
use PlatinumPlace\DgiiXmlSigner\Exception\DgiiXmlSignerException;

try {
    $manager = new SignManager();
    // Puedes usar sign() (estándar) o sing() (DGII)
    $signedXml = $manager->sign($p12Content, $password, $xmlContent);
} catch (DgiiXmlSignerException $e) {
    // Manejar error de certificado o firma
    echo $e->getMessage();
}
```
