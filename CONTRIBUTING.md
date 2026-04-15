# Guía de Contribución

¡Gracias por considerar contribuir a **PHP DGII XML Signer**! Toda ayuda es bienvenida para mantener esta herramienta actualizada con los estándares de la DGII.

## Proceso de Desarrollo

Para contribuir, sigue estos pasos:

1. Realiza un **Fork** del repositorio.
2. Crea una rama para tu característica o corrección (`git checkout -b feature/nueva-mejora`).
3. Instala las dependencias: `composer install`.
4. Realiza tus cambios asegurándote de seguir los estándares de código (PSR-12).
5. **Ejecuta las pruebas**: Asegúrate de que todo sigue funcionando con `composer test`.
6. **Verifica la calidad del código**:
   - Formato: `composer lint` (usamos PHP-CS-Fixer).
   - Análisis Estático: `composer analyze` (usamos PHPStan).
7. Realiza el **Commit** de tus cambios siguiendo [Conventional Commits](https://www.conventionalcommits.org/).
8. Realiza el **Push** a tu rama y abre un **Pull Request**.

## Estándares de Código

Utilizamos **PHP-CS-Fixer** para mantener un estilo de código consistente siguiendo el estándar PSR-12. Por favor, ejecuta `composer lint` antes de enviar cualquier cambio.

## Pruebas (Testing)

Si agregas una nueva funcionalidad, por favor incluye sus respectivos tests en la carpeta `tests/`. No se aceptarán Pull Requests que reduzcan la cobertura de pruebas actual o que introduzcan fallos en los tests existentes.

## Reporte de Errores

Si encuentras un error, por favor abre un *Issue* en GitHub detallando:
- Versión de PHP.
- Versión de la librería.
- Pasos para reproducir el error.
- El error obtenido (logs o mensajes de excepción).

---

¡Gracias por ayudar a la comunidad de facturación electrónica en República Dominicana!
