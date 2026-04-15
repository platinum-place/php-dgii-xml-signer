# Changelog

Todas las versiones notables de este proyecto se documentarán en este archivo siguiendo el formato [Keep a Changelog](https://keepachangelog.com/en/1.0.0/) y cumpliendo con el [Versionado Semántico](https://semver.org/lang/es/).

## [1.0.0] - 2024-05-15
### Añadido
- Clase `SignManager` como punto de entrada principal para el firmado.
- Implementación de `XmlSigner` personalizada para cumplir con la normalización C14N de la DGII.
- Alias del método `sign()` para mayor compatibilidad con estándares PSR.
- Soporte para la configuración "Legacy" de OpenSSL en entornos modernos.
- Excepción personalizada `DgiiXmlSignerException`.
- Pruebas unitarias y funcionales para el proceso de firmado.
- Documentación completa de código (DocBlocks) siguiendo estándares PSR-5.
- Guía de contribución y flujo de desarrollo profesional.
- Scripts de calidad de código con PHP-CS-Fixer y PHPStan.
