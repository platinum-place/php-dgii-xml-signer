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

- Usa **PHP 8.2** si necesitas trabajar con archivos `.p12`. Esta versión incluye OpenSSL 1.1.1p, que soporta el algoritmo necesario.

- En versiones más recientes de PHP u OpenSSL, el algoritmo requerido puede clasificarse como **"legacy"** y no estará disponible por defecto.

- Para solucionarlo:
  1. Modifica el archivo `openssl.cnf` para habilitar los algoritmos "legacy".
  2. Alternativamente, usa el argumento `-legacy` en los comandos de OpenSSL.

Esto garantiza que puedas trabajar con archivos `.p12` sin problemas.

## Referencias

- [Firmado de e-CF - DGII](https://dgii.gov.do/cicloContribuyente/facturacion/comprobantesFiscalesElectronicosE-CF/Documentacin%20sobre%20eCF/Instructivos%20sobre%20Facturaci%C3%B3n%20Electr%C3%B3nica/Firmado%20de%20e-CF.pdf)
- [Biblioteca xmldsig para PHP](https://github.com/selective-php/xmldsig)
- [Habilitar la compatibilidad heredada en OpenSSL](https://www.practicalnetworking.net/practical-tls/openssl-3-and-legacy-providers/).
