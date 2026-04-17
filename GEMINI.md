# PHP DGII XML Signer - Guía de Desarrollo

Librería PHP especializada para la firma digital de documentos XML conforme a los estándares de la **DGII** (República Dominicana).

## 🚀 Resumen del Proyecto

Este paquete implementa el estándar **XMLDSig** con personalizaciones críticas en el proceso de canonicalización (C14N) para asegurar que la firma sea aceptada por los servidores de la DGII.

### Tecnologías Principales
- **PHP 8.1+**
- **Librería Base:** `selective/xmldsig`.
- **OpenSSL:** Para la lectura de certificados y claves privadas.

## 🏗️ Arquitectura

- **`SignManager`:** Punto de entrada simplificado para el usuario.
- **`XmlSigner`:** Clase core que sobrescribe comportamientos de la librería base para cumplir con DGII.
- **`Exception/`:** Excepciones personalizadas para el dominio de firma.

## 🛠️ Comandos de Desarrollo

```bash
# Ejecutar pruebas (PHPUnit)
composer test

# Corregir estilo de código (PHP-CS-Fixer)
composer lint

# Análisis estático (PHPStan)
composer analyze
```

## 📝 Convenciones de Desarrollo

1.  **DocBlocks:** Todo el código fuente debe estar documentado utilizando DocBlocks en **Inglés**.
2.  **Canonicalización:** Cualquier cambio en `XmlSigner::signDocument` o `XmlSigner::appendSignature` debe ser validado contra el esquema oficial de la DGII, ya que la normalización es extremadamente sensible.
3.  **Certificados:** Asegurar compatibilidad con la configuración "legacy" de OpenSSL si es necesario para ciertos certificados `.p12`.

---
*Este archivo sirve como contexto para Gemini CLI. Mantener actualizado ante cambios arquitectónicos.*
