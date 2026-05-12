# PHP DGII XML Signer - Guía de Desarrollo

Este archivo es la fuente central de verdad para la arquitectura y convenciones de este proyecto. Está diseñado para ser interpretado tanto por **desarrolladores humanos** como por **Agentes de IA** (Gemini, Cursor, Copilot).

## 🚀 Descripción del Proyecto

Este paquete implementa el estándar **XMLDSig** con personalizaciones críticas en el proceso de canonicalización (C14N) para asegurar que la firma sea aceptada por los servidores de la DGII.

### Tecnologías Principales
- **PHP 8.1+**
- **Librería Base:** `selective/xmldsig`.
- **OpenSSL:** Para la lectura de certificados y claves privadas.

### Referencias Oficiales y Contexto
- **Contexto DGII:** Para reglas de negocio y normativa técnica oficial, consulta [docs/dgii/GEMINI.md](./docs/dgii/GEMINI.md).
- **[Documentación sobre e-CF](https://dgii.gov.do/cicloContribuyente/facturacion/comprobantesFiscalesElectronicosE-CF/Paginas/documentacionSobreE-CF.aspx)**
- **[Instructivo de Firmado de e-CF (PDF)](https://dgii.gov.do/cicloContribuyente/facturacion/comprobantesFiscalesElectronicosE-CF/Documentacin%20sobre%20eCF/Instructivos%20sobre%20Facturaci%C3%B3n%20Electr%C3%B3nica/Firmado%20de%20e-CF.pdf)**


## 🏗️ Arquitectura

- **`SignManager`:** Punto de entrada simplificado para el usuario.
- **`XmlSigner`:** Clase principal que sobreescribe los comportamientos de la librería base para cumplir con la DGII.
- **`Exception/`:** Excepciones personalizadas para el dominio de firma.

## 🤖 Alineación de IA
Si eres un Agente de IA trabajando en este repositorio:
1. **Prioridad Absoluta:** No ignores las reglas de canonicalización descritas en `XmlSigner`. Cualquier cambio debe ser validado contra el instructivo de la DGII en `docs/dgii/`.
2. **Estilo de Código:** Mantén los DocBlocks en inglés, pero el soporte técnico y comentarios de arquitectura en español.
3. **Pruebas:** Siempre verifica que los cambios no rompan la compatibilidad con los certificados OpenSSL "legacy".


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

1.  **DocBlocks:** Todo el código fuente debe estar documentado usando DocBlocks en **Inglés** (estándar de código).
2.  **Canonicalización:** Cualquier cambio en `XmlSigner::signDocument` o `XmlSigner::appendSignature` debe ser validado contra el esquema oficial de la DGII, ya que la normalización es extremadamente sensible.
3.  **Certificados:** Asegurar la compatibilidad con la configuración "legacy" de OpenSSL si es requerido para ciertos certificados `.p12`.

---
*Este archivo sirve como contexto para Gemini CLI. Manténgalo actualizado ante cambios arquitectónicos.*
