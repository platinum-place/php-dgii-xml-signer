# Documentación Técnica DGII (e-CF) - Alcance Firmado XML

Esta carpeta contiene los manuales técnicos oficiales de la DGII (Dirección General de Impuestos Internos) de la República Dominicana relevantes para el proceso de **firma digital** de comprobantes electrónicos (e-CF).

## Propósito para Agentes de IA
Utiliza esta documentación como fuente de verdad absoluta para cualquier consulta relacionada con la normativa de **XMLDSig** impuesta por la DGII. Esta librería se especializa exclusivamente en el proceso de firmado; por lo tanto, las instrucciones de IA deben centrarse en asegurar que el XML resultante cumpla con el estándar de canonicalización y estructura de firma requerido para ser aceptado por los servidores de la DGII.

## Índice de Documentos Disponibles

| Archivo | Contenido Principal | Relevancia para esta Librería |
| :--- | :--- | :--- |
| `Firmado de e-CF.md` | Especificaciones de firma digital (XMLDSig), algoritmos (SHA256), tipos de certificados y estructura del nodo `<Signature>`. | **Crítica**: Es la base técnica de todo el código en `src/`. |
| `Descripcion-tecnica-de-facturacion-electronica.md` | Arquitectura general, ambientes y flujos de alto nivel. | **Media**: Ayuda a entender el contexto donde se usa el XML firmado. |

## Reglas de Implementación y Consulta
- **Canonicalización (C14N)**: Cualquier cambio en la lógica de firma debe ser validado contra el instructivo `Firmado de e-CF.md`, específicamente en lo referente a la normalización sin comentarios.
- **Estructura del Nodo Signature**: La posición y los elementos hijos del nodo `<Signature>` deben seguir estrictamente lo indicado en el manual técnico.
- **Certificados**: El soporte para certificados `.p12`/`.pfx` debe cumplir con los estándares descritos en la normativa.

---
*Nota: Otros documentos de la normativa e-CF (como formatos de facturas o anulaciones) no se incluyen aquí por estar fuera del alcance de este paquete de firmado.*
