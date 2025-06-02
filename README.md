# PHP DGII XML Signer

Una librería en PHP para firmar documentos XML con firma digital conforme a los requerimientos de la **Dirección General de Impuestos Internos (DGII)** de República Dominicana para el sistema de **Comprobantes Fiscales Electrónicos (e-CF)**.

## Descripción

Este paquete proporciona las herramientas necesarias para firmar digitalmente documentos XML utilizando certificados digitales válidos, cumpliendo con las especificaciones técnicas establecidas por la DGII para la facturación electrónica en República Dominicana.

## Características

- ✅ Firma digital de documentos XML según estándares XMLDSig
- ✅ Compatible con certificados digitales emitidos por entidades certificadoras autorizadas
- ✅ Cumple con las especificaciones técnicas de la DGII
- ✅ Soporte para Comprobantes Fiscales Electrónicos (e-CF)
- ✅ Validación de estructura XML antes del firmado
- ✅ Fácil integración en aplicaciones PHP existentes

## Requisitos

- PHP 8.0 o superior
- Extensión OpenSSL habilitada
- Extensión XMLWriter habilitada
- Extensión DOMDocument habilitada
- Certificado digital válido emitido por una entidad certificadora autorizada

## Aclaraciones

Aunque la documentación de la DGII explica cómo utilizar la librería **XMLDSIG** paraleer los certificados, y esta aplicación está basada en esa documentación, destaco que, por lo menos para mí, hay una parte de la documentación que no está del todo clara.

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

La documentación menciona que la librería fue probada en PHP versiones 8.1.12 y 8.1.13, debido a que el cifrado RC2-40-CBC utilizado en los archivos .p12 cambió en las versiones más recientes de OpenSSL, que normalmente vienen con PHP 8.2 en adelante.

Al intentar leer el archivo .p12 con `openssl_pkcs12_read`, obtenemos un error porque OpenSSL dejó de admitir el cifrado RC2-40-CBC en versiones recientes debido a problemas de seguridad. Sin embargo, este cifrado aún es utilizado por la DGII en los certificados emitidos por entidades certificadas, como la Cámara de Comercio.

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

## Instalación

### Vía Composer (Recomendado)

```bash
composer require platinum-place/php-dgii-xml-signer
```

### Instalación Manual

```bash
git clone https://github.com/platinum-place/php-dgii-xml-signer.git
cd php-dgii-xml-signer
composer install
```

## Uso Básico

```php
<?php
use PlatinumPlace\Signer\SignManager;

$xmlDocument = '<?xml version="1.0" encoding="UTF-8"?>
<ECF xmlns="http://dgii.gov.do/e-CF/v1.0" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">
    <Encabezado>
        <Version>1.0</Version>
        <IdDoc>
            <TipoeCF>31</TipoeCF>
            <eNCF>E310000000001</eNCF>
            <FechaVencimientoSecuencia>2024-12-31</FechaVencimientoSecuencia>
        </IdDoc>
        <Emisor>
            <RNCEmisor>123456789</RNCEmisor>
            <RazonSocialEmisor>Mi Empresa SRL</RazonSocialEmisor>
        </Emisor>
        <Comprador>
            <RNCComprador>987654321</RNCComprador>
            <RazonSocialComprador>Cliente SRL</RazonSocialComprador>
        </Comprador>
        <Totales>
            <MontoGravadoTotal>1000.00</MontoGravadoTotal>
            <MontoGravadoI1>1000.00</MontoGravadoI1>
            <MontoImpuesto1>180.00</MontoImpuesto1>
            <MontoTotal>1180.00</MontoTotal>
        </Totales>
    </Encabezado>
    <DetallesItems>
        <Item>
            <NumeroLinea>1</NumeroLinea>
            <CodigoItem>PROD001</CodigoItem>
            <DescripcionItem>Producto de ejemplo</DescripcionItem>
            <CantidadItem>1</CantidadItem>
            <PrecioUnitarioItem>1000.00</PrecioUnitarioItem>
            <MontoItem>1000.00</MontoItem>
        </Item>
    </DetallesItems>
</ECF>';

try {
    $certContent = '/content/certificate.p12');
    $certPassword = 'password';

    $signedXML = (new SignManager)->sing($certContent, $certPassword, $xmlContent);
    
} catch (Exception $e) {
    echo "Error procesando e-CF: " . $e->getMessage() . "\n";
}
```

## Licencia

Este proyecto está licenciado bajo la Licencia MIT. Ver el archivo `LICENSE` para más detalles.

## Recursos Adicionales

- [Documentación Oficial DGII - Facturación Electrónica](https://dgii.gov.do)
- [Especificaciones Técnicas e-CF](https://dgii.gov.do/facturacionElectronica)
- [Guía de Implementación XMLDSig](https://www.w3.org/TR/xmldsig-core/)

### Error OpenSSL

Más detalles sobre el error pueden encontrarse en el siguiente enlace de Stack Overflow:  
[Convert an old-style .p12 to .pem - Unsupported Algorithm RC2-40-CBC](https://stackoverflow.com/questions/72859711/convert-an-old-style-p12-to-pem-unsupported-algorithm-rc2-40-cbc)