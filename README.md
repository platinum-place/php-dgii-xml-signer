# Firma Digital de Comprobantes Fiscales Electrónicos (e-CF) en PHP

Siguiendo las instrucciones proporcionadas por la Dirección General de Impuestos Internos (DGII) en su documento "[Firmado de e-CF](https://dgii.gov.do/cicloContribuyente/facturacion/comprobantesFiscalesElectronicosE-CF/Documentacin%20sobre%20eCF/Instructivos%20sobre%20Facturaci%C3%B3n%20Electr%C3%B3nica/Firmado%20de%20e-CF.pdf)", es posible realizar la firma digital de los e-CF utilizando diversos lenguajes de programación. En el caso de PHP, la DGII recomienda emplear la biblioteca [xmldsig](https://github.com/selective-php/xmldsig).

## Consideraciones Importantes

Aunque la documentación oficial es adecuada y cumple con los requisitos establecidos, es necesario destacar lo siguiente:

### Modificación en la Clase `XmlSigner`

En la clase `XmlSigner`, específicamente en la línea 179, se debe ajustar el método de canonicalización.  
El código original:

```php
$c14nSignedInfo = $signedInfoElement->C14N(false, false);
// o simplemente
$c14nSignedInfo = $signedInfoElement->C14N();
```

### Implementación de la Modificación

Para mantener la integridad de la biblioteca original y seguir las recomendaciones sin realizar cambios drásticos:

- Copiar la clase completa `XmlSigner` y crear una nueva clase en otra ubicación dentro de tu proyecto con las modificaciones necesarias.
- Referenciar esta nueva clase en la segunda clase recomendada por la documentación.

### Recomendación sobre la Versión de PHP y OpenSSL

- El problema ocurre porque OpenSSL 3.0 (utilizado en versiones recientes de PHP) clasifica algunos algoritmos como **"legacy"** y no los habilita por defecto, lo que impide trabajar con archivos `.p12` que usan esos algoritmos.

- **Solución 1**: Usa PHP 8.2, que incluye OpenSSL 1.1.1p, donde los algoritmos necesarios están habilitados por defecto.

- **Solución 2**: Si usas OpenSSL 3.0 o superior:
  1. Modifica el archivo `openssl.cnf` para activar el soporte "legacy". 
     - En la sección `[provider_sect]`, agrega:
       ```
       legacy = legacy_sect
       ```
     - En `[legacy_sect]`, asegura que esté:
       ```
       activate = 1
       ```
  2. Usa el argumento `-legacy` en comandos de OpenSSL:
     ```bash
     openssl pkcs12 -in archivo.p12 -legacy -nodes
     ```

Esto habilita los algoritmos necesarios y soluciona el problema.

## Referencias

- [Firmado de e-CF - DGII](https://dgii.gov.do/cicloContribuyente/facturacion/comprobantesFiscalesElectronicosE-CF/Documentacin%20sobre%20eCF/Instructivos%20sobre%20Facturaci%C3%B3n%20Electr%C3%B3nica/Firmado%20de%20e-CF.pdf)
- [Biblioteca xmldsig para PHP](https://github.com/selective-php/xmldsig)
- [Habilitar la compatibilidad heredada en OpenSSL](https://www.practicalnetworking.net/practical-tls/openssl-3-and-legacy-providers/).
