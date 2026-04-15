# Guía de Pruebas - DGII XML Signer

Este documento explica cómo realizar pruebas en el paquete para asegurar que el firmado funciona correctamente.

## Requisitos
- Composer instalado.
- Dependencias instaladas: `composer install`.
- Extensión `openssl` habilitada en PHP.

## Cómo ejecutar las pruebas
Para correr todos los tests, usa el siguiente comando desde la raíz del proyecto:

```bash
./vendor/bin/phpunit
```

## Pruebas con Certificados Reales
Para probar el proceso de firma con un certificado real (.p12) sin afectar el código de producción:

1.  Coloca tu certificado en `tests/Fixtures/tu_certificado.p12`.
2.  Abre el archivo `tests/SignManagerTest.php`.
3.  En el método `test_functional_signature_process`, actualiza:
    - El nombre del archivo certificado.
    - La **contraseña** del certificado (variable `$password`).
4.  Vuelve a ejecutar `./vendor/bin/phpunit`.

## Solución de Problemas (OpenSSL 3+)
Si recibes un error diciendo que no se pudo leer el certificado, es probable que necesites habilitar el modo **Legacy** en OpenSSL, ya que los certificados de la DGII suelen usar cifrados antiguos (RC2-40-CBC).

Consulta el archivo `README.md` para ver los pasos detallados de configuración en tu sistema operativo.
