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

### Recomendación sobre la Versión de PHP

- Se recomienda utilizar **PHP 8.2** debido a que la biblioteca OpenSSL incorporada en esta versión es compatible con la versión **1.1.1p**, la cual implementa el algoritmo necesario para la lectura de archivos `.p12`.
- Si se emplea una versión superior de PHP o de la biblioteca OpenSSL, es posible que el algoritmo requerido sea clasificado como **"legacy"**.
- Es factible acceder a las configuraciones del paquete y ajustarlas para que utilicen la versión **"legacy"** del algoritmo en cualquier versión de PHP o de la biblioteca, garantizando así la funcionalidad deseada.

## Referencias

- [Firmado de e-CF - DGII](https://dgii.gov.do/cicloContribuyente/facturacion/comprobantesFiscalesElectronicosE-CF/Documentacin%20sobre%20eCF/Instructivos%20sobre%20Facturaci%C3%B3n%20Electr%C3%B3nica/Firmado%20de%20e-CF.pdf)
- [Biblioteca xmldsig para PHP](https://github.com/selective-php/xmldsig)
