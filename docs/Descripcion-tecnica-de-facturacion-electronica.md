Descripción Técnica de
Facturación Electrónica

GERENCIA DE TECNOLOGIA DE LA INFORMACION Y COMUNICACIONES

Versión 1.6
Junio 2023

Republica Dominicana

Índice

Bitácora........................................................................................................................................................1

Propósito.....................................................................................................................................................4

Facturación Electrónica Autoridad Tributaria............................................................................4

Lenguaje Estándar de Comunicación......................................................................4

Descripción de Ambientes.....................................................................................5

Descripción de Servicios Web.................................................................................6

Estándar de Comunicación Emisor ‐ Receptor.........................................................................52

Requerimientos Generales...................................................................................52

Creación y Parametrización De Servicios..............................................................52

Restricciones de Contenido y/o Caracteres en los XML.........................................58

Formato de Nombre de los Archivos XML.............................................................59

Firmado de XML..................................................................................................60

Recomendaciones................................................................................................60

Bitácora

Actualizaciones al 12-06-2023

1. Se agregó un nuevo servicio de consulta de Resúmenes de factura que permite

consultar dado un RNC, ENCF y Código de seguridad un comprobante en
particular para ver el estado de este.

Actualizaciones al 18-05-2023

1. Se agregó un nuevo endpoint al servicio de consulta directorio que permite filtrar

por un RNC en particular.

2.  Se agregaron descripciones de los parámetros de salida de los servicios de

Impuestos Internos.

3.  Se agregaron nuevos puntos a los requerimientos generales del estándar de

comunicación emisor ‐ receptor.

‐ Servicios no sensitivos a mayúsculas y minúsculas.
‐ Uso de puertos de red tradicionales.

4. Se incluyeron dos parámetros “encf” y “secuencia Utilizada” a la respuesta del
servicio de Recepción del resumen de factura de consumo electrónica para
retroalimentar cuando el número de comprobante fiscal electrónico (eNCF) puede
ser reutilizado.

5.  Se incluyó el estado de disponibilidad de los servicios del ambiente de
precertificación en el servicio de estatus endpoint ObtenerEstatus.

6. Se agregó una referencia al formato de fecha universal que debe ser utilizado en

los parámetros de fecha expedición y expiración del token retornado por el
servicio de autenticación.

Actualizaciones al 18-04-2022

1. Se incluyeron dos parámetros a la respuesta del servicio de Consulta Resultado

para retroalimentar cuando el número del comprobante fiscal electrónico (eNCF)
puede ser reutilizado.

2.  Se especifica el estándar para el formato de codificación de caracteres.
3. Se especifica el estándar para el nombre de archivo de todos los formatos.
4. Se actualiza el periodo de vigencia de los envíos realizados en el ambiente de

precertificación.

Actualizaciones al 28-12-2021

    1.  Se actualizó la fecha de vencimiento de las secuencias habilitadas a los
contribuyentes para fines de prueba en el ambiente de precertificación.

1

Actualizaciones al 01-03-2021

     1. Se agregaron dos nuevos endpoint al servicio de Emisor/Receptor del ambiente

de pruebas para recibir aprobaciones comerciales y autenticarse.

     2. Se modificó la descripción del servicio de consulta directorio para destacar la
funcionalidad de este según el ambiente de interacción.

Actualizaciones al 28-12-2020

1. Se modificó el nombre de la subsección ‘Restricciones de caracteres’ a

‘Restricciones de contenido y/o caracteres’ y se agregó en la misma él no incluir
tags vacíos en los XML.

2. Se quitaron las URL del servicio de anulación rangos, consulta estado, consulta

trackids y consulta directorio para el ambiente de certificación conforme a que en
el mismo aún no se encuentran disponibles para el público.

3. Se completó la URL del servicio de Emisor Receptor del ambiente de pruebas,

agregando al final de la misma los recursos ‘/help/index.html’.

Actualizaciones al 02-10-2020

     1. Se agregó a modo referencia una barra inclinada al final de la URL del swagger
         del servicio de Recepción de Facturas de Consumo (FC).
     2. Se quitó la URL del servicio de Recepción de Facturas de Consumo (FC) para el
         ambiente de certificación conforme a que el mismo aún no se encuentra
         disponible para el público.

 3. Se especificó tanto en la descripción del servicio de recepción como en el

estándar de facturación electrónica, el formato que debe ser utilizado para el
nombre de los archivos (XML).

     4. Se agregaron puntos a tomar en cuenta con respecto al firmado de eCF en los
         requerimientos generales, así como recomendaciones a fines.
     5. Se le agregó el parámetro de la URL de autenticación al servicio de Envío de
         comprobantes en pre-certificación.
     6. Se agregó un cuadro con las restricciones de caracteres con respecto al código
         de seguridad de los QR conforme al uso apropiado para una composición de una
         URL.

2

7. Se agregó el nuevo servicio de Emisor-Receptor con la descripción y estructura
         de los siguientes endpoint para su interacción:

              EmisionComprobantes
              Consulta de acuse de recibo
              RecepcioneCF

     8. Se agrego a las URL base la estructura del dominio de los resúmenes de factura
         de consumo electrónica.

Actualizaciones al 30-04-2020

     1. Se modifican las URL del servicio de recepción del resumen de factura de
         consumo electrónica y el servicio de consulta timbre de dichas facturas de
         consumo electrónica conforme a un cambio de dominio.

Actualizaciones al 22-04-2020

     1. Se agregó referencia a informaciones importantes del ambiente de
         pre-certificación en el acápite de descripción de ambientes.
     2. Se agregó la descripción y estructura del nuevo servicio de consulta trackids al
         acápite de descripción de servicios web.

3

Propósito

El presente documento tiene por objetivo describir en sentido general los aspectos
técnicos que conforman el sistema fiscal de facturación electrónica de la Dirección
General de Impuestos Internos (DGII), así como de manera específica, los
requerimientos necesarios a disponibilizar por parte de los contribuyentes para entrar
en esta modalidad y comunicarse de manera correcta con la autoridad tributaria y
otros contribuyentes electrónicos.

Facturación Electrónica Autoridad Tributaria

Cuando se habla de Facturación electrónica, se refiere a la modalidad de negocios que
utiliza comprobantes fiscales electrónicos, en ese sentido, la presente sección detalla
los aspectos técnicos de la Dirección General de Impuestos Internos (DGII) tales como
el lenguaje de comunicación, ambientes y servicios web existentes.

Lenguaje Estándar de Comunicación.

Para el intercambio de información, se tiene establecido el lenguaje extensible de
marcas (XML), un estándar que a través de servicios web permite el intercambio de
información entre plataformas heterogéneas.

Para cada operación que se estará realizando en Facturación Electrónica, la autoridad
tributaria dispone de un formato preestablecido en el portal con la finalidad de
describir los datos y validaciones que estas operaciones contemplan, adicional a un
XSD a modo de referencia estructural de dichos XML.

Cada formato cuenta con un tag (etiqueta) por el cual se le reconoce, detallado a
continuación:

Formato XML

Etiqueta Madre (Obligatoria)

Formato e-CF

Formato Aprobación Comercial

Formato Acuse de recibo

Formato Anulación de secuencias e-NCF

Formato de Resumen Factura de Consumo
(32 < 250,000.00)

4

ECF

ACECF

ARECF

ANECF

RFCE

Descripción de Ambientes

En Facturación Electrónica, un ambiente es un entorno que permite a los
contribuyentes interactuar con los servicios de la Autoridad Tributaria en diferentes
contextos, contándose actualmente con los siguientes:

         Pre-Certificación: publica los servicios a efectos de que los contribuyentes
puedan realizar pruebas de adecuación e integración de sus sistemas,
almacenando los envíos por un periodo de 60 días.

         Todo contribuyente habilitado en este ambiente dispone por tipo de
         comprobante de un rango de secuencias de 1 a 10,000,000, a excepción de
         las facturas de consumo electrónicas (32) que disponen de un rango de 1 a
         50,000,000.

La fecha de vencimiento de estas secuencias corresponde al 31-12-2025, a
excepción de las facturas de consumo electrónicas (32) y las notas de crédito
electrónica (34) que no llevan fecha de vencimiento de secuencia.

         Certificación: ambiente que tiene por objetivo validar capacidades por parte del
sistema del contribuyente previo a su incorporación productiva al sistema fiscal
de facturación electrónica, debiendo para ello agotar un conjunto de pruebas
que requieren el uso de los servicios web.

Producción: ambiente productivo donde todo envío y operación tiene validez

         fiscal.

Pre-Certificación

Ambientes

Producción

Certificación

Ilustración de Ambientes

5

En cada URL base de los diferentes ambientes se puede encontrar el documento
Swagger (OpenAPI) el cual especifica la lista de recursos disponibles en el API REST y
las operaciones (Métodos) a los que se puede invocar en cada uno de ellos, con sus
parámetros y posibles respuestas.

A continuación, podrán identificar la estructura definida para la comunicación o
invocación de los servicios de facturación electrónica según el ambiente:

TesteCF: Ambiente de pre-certificación, ejemplo:
https://ecf.dgii.gov.do/testecf/nombredelservicio/help/index.html
https://fc.dgii.gov.do/testecf/ nombredelservicio/help/index.html

CerteCF: Ambiente de certificación, ejemplo:
https://ecf.dgii.gov.do/certecf/nombredelservicio/help/index.html
https://fc.dgii.gov.do/certecf/nombredelservicio/help/index.html

eCF: Ambiente de producción, ejemplo:
https://ecf.dgii.gov.do/ecf/nombredelservicio/help/index.html
https://fc.dgii.gov.do/ecf/nombredelservicio/help/index.html

Estructura de los servicios y ambientes de facturación electrónica de la
Dirección General de Impuestos Internos (DGII), para mayor detalle dirigirse
a la sección de Descripción de Servicios Web.

Descripción de Servicios Web

Los servicios web, son un conjunto de protocolos y estándares que en este caso
mediante el uso del lenguaje extensible de marcas (XML) y API REST, permiten el
intercambio de datos entre los softwares de facturación heterogéneos de los
contribuyentes y la autoridad tributaria a través de un entorno definido como
{Ambiente}, encontrándose en facturación electrónica los siguientes servicios:

6

Autenticación

Servicio web responsable de generar una sesión para el contribuyente, validando su
identidad mediante el uso de un certificado digital sobre un archivo (Semilla) que
obtendrá de una petición y el cual, deberá enviar firmado para recibir un token con
una duración determinada (1 hora por el momento).

Con la entrega de dicho token el contribuyente podrá utilizar los restantes servicios de
facturación electrónica, especificándolo como header de autorización de los requests
(Authorization: Bearer {token}).

7

URLs del servicio

          TesteCF: Ambiente de pre-certificación:
         https://ecf.dgii.gov.do/testecf/autenticacion

         CerteCF: Ambiente de certificación:
         https://ecf.dgii.gov.do/certecf/autenticacion

         eCF: Ambiente de producción:
         https://ecf.dgii.gov.do/ecf/autenticacion

8

Métodos y parámetros

Dentro de la URL, se encontrarán los siguientes dos (2) recursos (Endpoint):

OBTENER ARCHIVO SEMILLA

DESCRIPCIÓN

Retorna el archivo semilla (en formato XML) que
permitirá obtener el token.

MÉTODO

GET

RECURSO

(ENDPOINT)

/api/autenticacion/semilla

REQUEST URL

https://eCF.dgii.gov.do/{ambiente}/autenticacion/api/
autenticacion/semilla

curl -X 'GET' \

EJEMPLO CURL

'https://ecf.dgii.gov.do/testecf/autenticacion/api/autenticacion/
semilla' \
-H 'accept: */*' \

ENTRADA

Parámetros de entrada
N/A

SALIDA

Respuesta en formato XML

<?xml version="1.0" encoding="utf‐8"?>
<SemillaModel
xmlns:xsi="http://www.w3.org/2001/XMLSchema‐instance"
xmlns:xsd="http://www.w3.org/2001/XMLSchema">
<valor>0000000‐0000‐0000‐0000‐000000000000</valor>
 <fecha>2019‐03‐13T14:33:32.8617792‐04:00</fecha>
 </SemillaModel>

DESCRIPCIÓN

- Valor: valor de la semilla, secuencia de caracteres

PARAMETROS

DE SALIDA

encriptados.
Fecha: fecha y hora en la cual se generó el archivo semilla.

-

9

VALIDACIÓN DE ARCHIVO: VALIDAR SEMILLA

DESCRIPCIÓN

Permite el envío del archivo (Semilla) firmado y retorna un
objeto que contiene un string de autenticación (token)
asociado a una fecha de emisión y una fecha de expiración del
token recibido.

MÉTODO

POST

RECURSO

(ENDPOINT)

/api/autenticacion/validarsemilla

REQUEST URL

https://ecf.dgii.gov.do/{ambiente}/autenticacion/api/a
utenticacion/validarsemilla

EJEMPLO CURL

curl -X 'POST' \

'https://ecf.dgii.gov.do/testecf/autenticacion/api/autenticacion/
validarsemilla' \

  -H 'accept: application/json' \

  -H 'Content-Type: multipart/form-data' \

  -F 'xml=@response_1659304894166.xml;type=text/xml'

ENTRADA

Parámetros de entrada
xml*

Respuesta en formato JSON
                      {
                      "token": "string",

FORMATO

SALIDA

                      "expira": " yyyy-MM-ddTHH:mm:ssZ ",

                      "expedido": " yyyy-MM-ddTHH:mm:ssZ"

                      }

Respuesta en formato XML
                     <?xml version="1.0" encoding="UTF‐8"?>

                                 <RespuestaAutenticacion>
                                          <token>string</token>
 <expira>yyyy-MM-ddTHH:mm:ssZ </expira>
 <expedido>yyyy-MM-ddTHH:mm:ssZ </expedido>
                                 </RespuestaAutenticacion>

10

- Token: valor emitido por Impuestos Internos como llave de

seguridad para utilizar los servicios de Facturación
Electrónica.
Expira: fecha y hora en la cual expira el token recibido.
Expedido: fecha y hora en la cual se recibió el token.

-
-

Ver RCF 6750 (https://tools.ietf.org/html/rfc6750) para más información sobre la
autenticación por tokens.

Recepción de e‐CF

Servicio web responsable de recibir un e‐CF tentativo (XML firmado digitalmente) y un
token asociado a una sesión válida y en respuesta retornar un objeto que contiene un
string denominado TrackId a modo de acuse de recibo, con el cual, el contribuyente
podrá consultar el estado de su validación.

La recepción del TrackId y haber recibido un estado de validación satisfactorio,
habilita al emisor al envío del e‐CF al receptor y en caso de que este no sea electrónico,
la entrega de la correspondiente representación impresa.

Las Facturas de Consumo Electrónica con un monto inferior a los RD$250,000.00, no
serán recibidos por este servicio, se deberá remitir un resumen de este al servicio
recepción de resumen factura de consumo e-CF.

Adicionalmente, los XML que representan los e-CFs deberán cumplir con el Formato de
Nombre de Archivo especificado en la sección “Estándar de Comunicación
Emisor-Receptor”

11

DESCRIPCIÓN PARAMETROS DE SALIDAURLs del servicio

          TesteCF: Ambiente de pre-certificación:
         https://ecf.dgii.gov.do/testecf/recepcion

         CerteCF: Ambiente de certificación:
         https://ecf.dgii.gov.do/certecf/recepcion

         eCF: Ambiente de producción:
         https://ecf.dgii.gov.do/ecf/recepcion

MÉTODOS Y PARÁMETROS

MÉTODO

POST

RECURSO

(ENDPOINT)

/api/facturaselectronicas

REQUEST URL

https://ecf.dgii.gov.do/{ambiente}/recepcion/api/facturas
electronicas

EJEMPLO CURL

curl -X 'POST' \

'https://ecf.dgii.gov.do/testecf/recepcion/api/facturaselectronic
as' \
  -H 'accept: application/json' \
  -H 'Authorization: bearer
eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJodHRwOi8vc2NoZW1h
cy54bWxzb2FwLm9yZy93cy8yMDA1LzA1L2lkZW50aXR5L2NsYW
ltcy9uYW1lIjoiMDAxOTk5OTk5OTYiLCJqdGkiOiI2MzhjZDdjNS0x
Y2NlLTQyMmUtYjNkMC0wMGQ4MTczMzYxNWUiLCJuYmYiOjE2N
TkzMDY5NzIsImV4cCI6MTY1OTMxMDU3MiwiaXNzIjoiREdJSS5GR
SIsImF1ZCI6IlVTVUFSSU9TLkRHSUkuRkUifQ.4qk1-0iqWkXcBC-n_J
TEYoeniie90-ZnXSc8ya1l8Yw' \
  -H 'Content-Type: multipart/form-data' \
  -F 'xml=@response_1659304894166.xml;type=text/xml'

ENTRADA

Parámetros de entrada
xml*

12

FORMATOS

SALIDA

Respuesta en formato JSON
                      {
                      "trackId": "string",

                      "error": "string",

                      "mensaje": "string"

                      }

Respuesta en formato XML

         <?xml version="1.0" encoding="UTF‐8"?>
         <RespuestaRecepcion>

                  <trackId>string</trackId>

                  <error>string</error>

                  <mensaje>string</mensaje>

</RespuestaRecepcion>

- Token: valor emitido por Impuestos Internos como llave de
- Trackid: número único generado por Impuestos Internos a

seguridad para utilizar los servicios de Facturación
un e-CF recibido.
Electrónica.
Error: motivo del mensaje de error recibido (Si aplica).
-
-
Expira: fecha y hora en la cual expira el token recibido.
- Mensaje: mensaje asociado a un error recibido al intentar
Expedido: fecha y hora en la cual se recibió el token.
-
enviar un e-CF (Si aplica).

Recepción de resumen factura de consumo e-CF

Servicio web responsable de recibir un resumen que contiene las informaciones
principales del e‐CF correspondiente a Facturas de Consumo Electrónica con un monto
inferior a los RD$250,000.00 (XML firmado digitalmente) y un token asociado a una
sesión válida y en respuesta retornar Aceptado en caso de recepción y procesamiento
exitoso, Aceptado condicional de encontrarse que no cumplió en algún punto pero
que no ameritó el rechazo de este o de lo contrario Rechazado.

A pesar de que estaremos recibiendo un resumen, el contribuyente deberá conservar
el e-CF extendido correspondiente a la Factura de Consumo Electrónica para futuros
procesos en que se ameriten.

Los e-CF correspondientes a Factura de Consumo Electrónica con un monto superior o
igual a los RD$250,000.00 deben ser remitidas en su totalidad (todas las
informaciones correspondientes a este e-CF) por el servicio de Recepción de e-CF.

13

DESCRIPCIÓN PARAMETROS DE SALIDADESCRIPCIÓN PARAMETROS DE SALIDA
Adicionalmente, los XML que representan estos resúmenes deberán cumplir con el
Formato de Nombre de Archivo especificado en la sección “Estándar de
Comunicación Emisor-Receptor”

URLs del servicio

          TesteCF: Ambiente de pre-certificación:
         https://fc.dgii.gov.do/testecf/recepcionfc/

         eCF: Ambiente de producción:
        https://fc.dgii.gov.do/ecf/recepcionfc/

MÉTODOS Y PARÁMETROS

MÉTODO

POST

RECURSO

(ENDPOINT)

/api/recepcion/ecf

REQUEST URL

https://fc.dgii.gov.do/{ambiente}/recepcionfc/api/recepcion/ecf

14

EJEMPLO CURL

curl -X POST
"https://fc.dgii.gov.do/testecf/recepcionfc/api/recepcion/ecf"
-H "accept: application/json"
-H "Authorization: bearer
eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJodHRwOi8vc2NoZW1h
cy54bWxzb2FwLm9yZy93cy8yMDA1LzA1L2lkZW50aXR5L2NsYW
ltcy9uYW1lIjoiMDAxOTk5OTk5OTYiLCJqdGkiOiI2MzhjZDdjNS0x
Y2NlLTQyMmUtYjNkMC0wMGQ4MTczMzYxNWUiLCJuYmYiOjE2N
TkzMDY5NzIsImV4cCI6MTY1OTMxMDU3MiwiaXNzIjoiREdJSS5GR
SIsImF1ZCI6IlVTVUFSSU9TLkRHSUkuRkUifQ.4qk1-0iqWkXcBC-n_J
TEYoeniie90-ZnXSc8ya1l8Yw"
-H "Content-Type: multipart/form-data"
-F
"xml=@response_1659306932058_180702.xml;type=text/xml"

ENTRADA

Parámetros de entrada
xml*

Respuesta en formato JSON

FORMATOS

SALIDA

{
  "codigo": 1,
  "estado": "string",
  "mensajes": [
    {
      "codigo": "string",
      "valor": "string"
    }
  ],
  "encf": "string",
  "secuenciaUtilizada": true
}

Respuesta en formato XML

<?xml version="1.0" encoding="UTF-8"?>
<Respuesta>
<codigo>1</codigo>
<estado>string</estado>
<mensajes>
<codigo>string</codigo>
<valor>string</valor>
</mensajes>
<encf>string</encf>

              <secuenciaUtilizada>true</secuenciaUtilizada>

</Respuesta>

15

DESCRIPCIÓN

PARAMETROS

DE SALIDA

- Código: código asociado al estado de validación del resumen

-

de factura de consumo recibido.
estado: estado de validación otorgado por Impuestos Internos
al resumen de factura de consumo recibido.

- mensajes: mensajes y códigos asociados al estado de

-

-

validación del resumen de factura de consumo recibido.
encf: número de secuencia utilizada por el contribuyente en el
resumen de factura de consumo.
secuenciaUtilizada: permite dar a conocer si el número de
secuencia que fue recibido por Impuestos Internos puede
reutilizarse en otro Resumen de Factura de Consumo en el
escenario de que el resultado de la validación haya sido
“Rechazado” por los siguientes motivos:

• Certificado y/o firma inválida.
• Estructura del comprobante (XML) no es válida.
• Firmante del comprobante fiscal electrónico no

corresponde a un delegado autorizado para hacer
transacciones para el RNC Emisor.

• El e-NCF no está autorizado para el RNC Emisor del

comprobante fiscal electrónico.

• El e-NCF autorizado se encuentra vencido a la fecha de

envío del comprobante fiscal electrónico.

• El RNC Emisor del comprobante no corresponde a un

emisor electrónico.

• El RNC Emisor no existe.
• El RNC Emisor no se encuentra activo.

Posibles valores del parámetro:

• True = No puede reutilizarse la secuencia.
• False = Puede reutilizarse la secuencia.

16

Consulta de Resumen de Factura (RFCE)

Servicio web responsable de responder la validez o estado de un ENCF a un receptor o
incluso a un emisor, a través de la presentación del RNC emisor, e‐NCF y el código de
seguridad.

Para realizar las consultas de los datos previamente descritos, se requiere que el
usuario autenticado se encuentre delegado para el emisor.

A través de este servicio también pueden ser consultados los e-CF remitidos por el
servicio de recepción de resumen factura de consumo inferiores a los RD$250,000.00.

URLs del servicio

          eCF: Ambiente de producción:
         https://fc.dgii.gov.do/ecf/consultarfce

17

MÉTODOS Y PARÁMETROS

MÉTODO

GET

RECURSO

(ENDPOINT)

REQUEST URL

EJEMPLO CURL

/api/Consultas/Consulta

https://fc.dgii.gov.do/ecf/consultarfce/api/Consultas/Consu
lta?RNC_Emisor=111111111&ENCF=E320000000000&Cod_S
eguridad_eCF=XXXXXX

curl -X 'GET' \

'https://fc.dgii.gov.do/ecf/consultarfce/api/Consultas/Consulta
?RNC_Emisor=111111111&ENCF=
E320000000000&Cod_Seguridad_eCF=XXXXXX' \
  -H 'accept: application/json' \
  -H 'Authorization: bearer
eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJodHRwOi8vc2NoZW1h
cy54bWxzb2FwLm9yZy93cy8yMDA1LzA1L2lkZW50aXR5L2NsYW
ltcy9uYW1lIjoiMDAxOTk5OTk5OTYiLCJqdGkiOiJmNmM1MmIzZi1
iM2I4LTQzMTEtYmIxZC01ZjhiMjE1NGI1MjEiLCJuYmYiOjE2ODU5
NzY5NjEsImV4cCI6MTY4NTk4MDU2MSwiaXNzIjoiREdJSS5GRSIsI
mF1ZCI6IlVTVUFSSU9TLkRHSUkuRkUifQ.atKesEcKiSJ_JOCKMD1H
safV6qDxxeEdhSjWLKdotjg'

ENTRADA

Parámetros de entrada
RncEmisor *
ENCF *
CodigoSeguridad *

FORMATOS

SALIDA

Respuesta en formato JSON
                     {
  "rnc": "string",
  "encf": "string",
  "secuenciaUtilizada": true,
  "codigo": "string",
  "estado": "string",
  "mensajes": [

17

FORMATOS

SALIDA

    {
      "valor": "string",
      "codigo": 0
    }
  ]
}

- Código: código asociado al estado de validación del e-CF

-

recibido.
Estado: estado de validación otorgado por Impuestos
Internos al e-CF recibido.

- RncEmisor: número de registro nacional del contribuyente

que envió el e-CF.

- NcfElectronico: número de secuencia utilizada por el

-

contribuyente en el ENCF.
codigoSeguridad: extraído de los primeros seis (6) dígitos
del hash generado en el SignatureValue de la firma digital
que viene en el tap CodigoSeguridadeCF del resumen de
factura.

No encontrado (0): implica que no se encontró el
comprobante en los registros, pudiendo deberse a que aún
no haya sido reportado.

Aceptado (1): implica que el e-CF generado por el emisor fue
aceptado y tiene validez fiscal.

Rechazado (2): corresponde a la nulidad del comprobante
generado por el emisor.

Nota: en adición a los estados anteriores, el servicio permite
visualizar comprobantes cuyo estado es ‘Aceptado condicional’
exclusivamente para Facturas de Consumo Electrónica con un
monto inferior a los RD$250,000.00.

17

DESCRIPCIÓN PARAMETROS DE SALIDAESTADOS SALIDAConsulta de resultado e‐CF

Servicio web responsable de retornar el estado de procesamiento o validez del e‐CF
tentativo enviado exclusivamente mediante el servicio web de recepción de e‐CF, a
través de la presentación de un Trackid y un token asociado a una sesión válida.

URLs del servicio

          TesteCF: Ambiente de pre-certificación:
         https://eCF.dgii.gov.do/testecf/consultaresultado

         CerteCF: Ambiente de certificación:
         https://eCF.dgii.gov.do/certecf/consultaresultado

         eCF: Ambiente de producción:
         https://eCF.dgii.gov.do/ecf/consultaresultado

17

MÉTODOS Y PARÁMETROS

MÉTODO

GET

RECURSO

(ENDPOINT)

/api/consultas/estado

REQUEST URL

https://ecf.dgii.gov.do/{ambiente}/consultaresultado/api/consu
ltas/estado?trackid={trackid}

EJEMPLO CURL

curl -X 'GET' \

'https://ecf.dgii.gov.do/testecf/consultaresultado/api/consultas
/estado?trackid=ddddd' \
  -H 'accept: application/json' \
  -H 'Authorization: bearer
eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJodHRwOi8vc2NoZW1h
cy54biLCJqdGkiOiI0wMGQ4MTczMzYxNWUiLCJuYmYiOjE2NTkz
MD-ZnXSc8ya1l8Yw'

ENTRADA

Parámetros de entrada
TrackId*

FORMATOS

SALIDA

Respuesta en formato JSON
        {
         "trackId": "string",
         "codigo": 0,
         "estado": "string",
         "rnc": "string",

  "eNCF": "string",
  "secuenciaUtilizada": true,
         "fechaRecepcion": "string",
         "mensajes": [
          {
            "valor": "string",
            "codigo": 0
           }
         ]
       }

18

FORMATOS

SALIDA

DESCRIPCIÓN

PARAMETROS

DE SALIDA

Respuesta en formato XML

           <?xml version="1.0" encoding="UTF-8"?>

          <RespuestaConsultaTrackId>

<trackId>string</trackId>

                        <codigo>0</codigo >

 <estado>string</estado>

<rnc>string</rnc>

<encf>string</ encf >

< secuenciaUtilizada>true</ secuenciaUtilizada>

<fechaRecepcion>string</fechaRecepcion>

<mensajes>

<valor>string</valor>

<codigo>0</codigo>

</mensajes>

</RespuestaConsultaTrackId>

-

trackId: número único generado por Impuestos Internos a
un e-CF recibido.

- Código: código asociado al estado de validación del e-CF

-

recibido.
Estado: estado de validación otorgado por Impuestos
Internos al e-CF recibido.

- Rnc: número de registro nacional del contribuyente que

-

-

envió el e-CF.
eNCF: número de secuencia utilizada por el contribuyente en
el e-CF.
fechaRecepcion: fecha en la cual Impuestos Internos recibió
el e-CF.

- mensajes: mensaje asociado al estado de validación del e-CF

-

recibido.
secuenciaUtilizada permite dar a conocer si el número de
secuencia que fue recibido por Impuestos Internos puede
reutilizarse en otro Comprobante Fiscal Electrónico (e-CF) en
el escenario de que el resultado de la validación haya sido
“Rechazado” por los siguientes motivos:

• Certificado y/o firma inválida.
• Estructura del comprobante (XML) no es válida.

19

DESCRIPCIÓN

PARAMETROS

DE SALIDA

• Firmante del comprobante fiscal electrónico no

corresponde a un delegado autorizado para hacer
transacciones para el RNC Emisor.

• El e-NCF no está autorizado para el RNC Emisor del

comprobante fiscal electrónico.

• El e-NCF autorizado se encuentra vencido a la fecha de

envío del comprobante fiscal electrónico.

• El RNC Emisor del comprobante no corresponde a un

emisor electrónico.

• El RNC Emisor no existe.
• El RNC Emisor no se encuentra activo.

Posibles valores del parámetro:

• True = No puede reutilizarse la secuencia.
• False = Puede reutilizarse la secuencia.

       No encontrado (0): implica que no se encontró el
       trackid en los registros.

       Aceptado (1): implica la validez del e‐CF.

       Rechazado (2): implica la nulidad del comprobante para
       fines tributario debido a que en algún punto no cumplió.

ESTADOS

SALIDA

       En Proceso (3): corresponde a que el comprobante aún
       no ha sido validado y por ende se debe esperar un
       tiempo prudencial antes de volver a consultar.

El promedio estimado de validación es de 200 ms.

       Aceptado Condicional (4): corresponde a que el
       comprobante no cumplió en algún punto pero que no
       amerito el rechazo de este y por ende implica la validez
       del e‐CF.

20

Consulta de estado e‐CF

Servicio web responsable de responder la validez o estado de un e‐CF a un receptor o
incluso a un emisor, a través de la presentación del RNC emisor, e‐NCF y dos campos
condicionales a la vigencia del comprobante, RNC Comprador y el código de
seguridad.

Para realizar las consultas de los datos previamente descritos, se requiere que el
usuario autenticado se encuentre delegado para el emisor o para el receptor.

A través de este servicio también pueden ser consultados los e-CF remitidos por el
servicio de recepción de resumen factura de consumo inferiores a los
RD$250,000.00.

URLs del servicio

          TesteCF: ambiente de pre-certificación:
         https://ecf.dgii.gov.do/testecf/consultaestado

         eCF: ambiente de producción:
         https://ecf.dgii.gov.do/ecf/consultaestado

21

MÉTODOS Y PARÁMETROS

MÉTODO

GET

RECURSO

(ENDPOINT)

REQUEST URL

EJEMPLO CURL

/api/consultas/estado

https://ecf.dgii.gov.do/{ambiente}/consultaestado/api/consultas/
estado?rncemisor={rncemisor}&ncfelectronico={ncfelectronico}&rn
ccomprador={rnccomprador}&codigoseguridad={codigoseguridad}

curl -X 'GET' \

'https://ecf.dgii.gov.do/testecf/consultaestado/api/consultas/e
stado?rncemisor=131880738&ncfelectronico=e3100000000&rn
ccomprador=131880738&codigoseguridad=884848448' \
  -H 'accept: application/json' \
  -H 'Authorization: bearer
eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJodHRwOi8vc2NoZW1j
NkMC0wMGQ4MTczMzYxNWUiLCJuYmYiOjya1l8Yw'

ENTRADA

Parámetros de entrada

RncEmisor *

NcfElectronico *

RncComprador

CodigoSeguridad

FORMATOS

SALIDA

Respuesta en formato JSON
        {
          "codigo": 0,
          "estado": "string",
          "rncEmisor": "string",
          "ncfElectronico": "string",
          "montoTotal": 0,
          "totalITBIS": 0,
          "fechaEmision": "string",
          "fechaFirma": "string",
          "rncComprador": "string",
          "codigoSeguridad": "string",
          "idExtranjero": "string"

          }

22

FORMATOS

SALIDA

Respuesta en formato XML

           <?xml version="1.0" encoding="UTF-8"?>

           <RespuestaConsultaEstado>

                       <codigo>0</codigo >

 <estado>string </estado>

                       <rncEmisor>string</rncEmisor>

<ncfElectronico>string</ncfElectronico>

<montoTotal>0</montoTotal>

<totalITBIS>0</totalITBIS>

<fechaEmision>string</fechaEmision>

<fechaFirma>string</fechaFirma>

<rncComprador>string</rncComprador>

<codigoSeguridad>string</codigoSeguridad>

<idExtranjero>string</idExtranjero>

          </RespuestaConsultaEstado>

- Código: código asociado al estado de validación del e-CF

-

recibido.
Estado: estado de validación otorgado por Impuestos Internos
al e-CF recibido.

- RncEmisor: número de registro nacional del contribuyente que

envió el e-CF.

- NcfElectronico: número de secuencia utilizada por el

DESCRIPCION

contribuyente en el e-CF.

PARAMETROS

DE SALIDA

- MontoTotal: extraído del e-CF recibido.
totalITBIS: extraído del e-CF recibido.
-
fechaEmision: extraído del e-CF recibido.
-
fechaFirma: extraído del e-CF recibido.
-
rncComprador: extraído del e-CF recibido (Si aplica).
-
codigoSeguridad: extraído de los primeros seis (6) dígitos del
-
hash generado en el SignatureValue de la firma digital del e-CF
recibido.
idExtranjero: extraído del e-CF recibido (Si aplica).

-

23

       No encontrado (0): implica que no se encontró el
       comprobante en los registros, pudiendo deberse a que
       aún no haya sido reportado.

ESTADOS

SALIDA

       Aceptado (1): implica que el e-CF generado por el
       emisor fue aceptado y tiene validez fiscal.

      Rechazado (2):  corresponde a la nulidad del
      comprobante generado por el emisor.

Nota: en adición a los estados anteriores, el servicio permite visualizar
comprobantes cuyo estado es ‘Aceptado condicional’ exclusivamente

para Facturas de Consumo Electrónica con un monto inferior a los

RD$250,000.00.

Consulta de trackId e‐CF

Servicio web responsable de retornar un listado de respuestas (Trackids) de un número
de comprobante fiscal electrónico (e-NCF) que haya sido recibido por DGII, a través de
la presentación del RNC Emisor, el e-NCF a consultar y un token asociado a una sesión
válida.

Se pueden obtener múltiples TrackIds cuando se remite varios e-CF con el mismo
número de comprobante fiscal (e-NCF) asociados al mismo RNC.

Para poder realizar la consulta satisfactoriamente, se requiere que el usuario
autenticado se encuentre delegado para el emisor, de lo contrario, no podrá obtener
los datos.

24

URLs del servicio

          TesteCF: Ambiente de pre-certificación:
         https://ecf.dgii.gov.do/testecf/consultatrackids

         ecf: Ambiente de producción:
         https://ecf.dgii.gov.do/ecf/consultatrackids

MÉTODOS Y PARÁMETROS

MÉTODO

GET

RECURSO

(ENDPOINT)

/api/trackids/consulta

REQUEST URL

https://ecf.dgii.gov.do/{ambiente}/consultatrackids/api/
trackids/consulta?rncemisor=xxxxxxxxx&encf=xxxxxxxxxxxx

25

curl -X 'GET' \

'https://ecf.dgii.gov.do/testecf/consultatrackids/api/trackids/co
nsulta?rncemisor=xxxxxxxxx&encf=xxxxxxxxxxxxx' \

EJEMPLO CURL

-H 'accept: application/json' \
-H 'Authorization: bearer

eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJodHRwOi8vc2NoZW1j
NkMC0wMGQ4MTczMzYxNWUiLCJuYmYiOjya1l8Yw'

ENTRADA

Parámetros de entrada
RncEmisor*
Encf*

VALIDACIONES

• El campo RNC Emisor es requerido.
• El campo ENCF es requerido.
• La longitud del RNC Emisor es inválida.
• La longitud del ENCF es inválida.
• El ENCF es inválido.
• El RNC del token no está autorizado a consultar el trackid de
este e-NCF, favor verificar que se encuentre delegado por el
emisor y volver a intentarlo.

FORMATO

SALIDA

Respuesta en formato JSON
                      {
                      "trackId": "string",

                      "estado": "string",

                      "fechaRecepcion": "string"

                      }

Respuesta en formato XML

<?xml version="1.0" encoding="UTF-8"?>

          <TrackingDetalle>

          <trackId>string</trackId>

          <estado>string</estado>

          <fechaRecepcion>string</fechaRecepcion>

</TrackingDetalle>

26

DESCRIPCIÓN

PARAMETROS

DE SALIDA

-

-

-

trackId: número único generado por Impuestos Inter-
nos al e-CF recibido.
estado: estado de validación otorgado por Impuestos
Internos al e-CF recibido.
fechaRecepcion: fecha en la cual Impuestos Internos
recibió el e-CF.

ESTADOS

SALIDA

No encontrado: implica que no se encontró el e-CF en
los registros.

Aceptado: implica la validez del e‐CF.

Rechazado: implica la nulidad del comprobante para
fines tributario debido a que en algún punto no cumplió.

Aceptado Condicional: corresponde a que el
comprobante no cumplió en algún punto, pero no
amerito el rechazo de este y por ende implica la validez
del e‐CF.

En proceso: corresponde a que el comprobante aún no
ha sido validado y por ende se debe esperar un tiempo
prudencial antes de volver a consultar.

El promedio estimado de validación es de 200 ms.

Recepción de aprobación comercial

Servicio web responsable de recibir aprobaciones comerciales emitidas por
contribuyentes receptores, la cual consiste en la conformidad con una transacción
llevada a cabo entre dos contribuyentes y de la cual se recibió un comprobante
electrónico de un emisor.

27

PARÁMETROS, RESPUESTA Y OTROS DATOSURLs del servicio

          TesteCF: Ambiente de pre-certificación:
         https://eCF.dgii.gov.do/testecf/aprobacioncomercial

         CerteCF: Ambiente de certificación:
         https://eCF.dgii.gov.do/certecf/aprobacioncomercial

         eCF: Ambiente de producción:
         https://ecf.dgii.gov.do/ecf/aprobacioncomercial

MÉTODOS Y PARÁMETROS

MÉTODO

POST

RECURSO

(ENDPOINT)

/api/aprobacioncomercial

REQUEST URL

https://ecf.dgii.gov.do/{ambiente}/aprobacioncomercial/api/apro
bacioncomercial

EJEMPLO CURL

  curl -X 'POST' \

'https://ecf.dgii.gov.do/testecf/aprobacioncomercial/api/aproba
cioncomercial' \

  -H 'accept: application/json' \
  -H 'Authorization: bearer

eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJodHRwOi8vc2NoZ4cCI
6MTY1OTMxMDU3MiwiXcnXSc8ya1l8Yw' \

  -H 'Content-Type: multipart/form-data' \
  -F

'xml=@response_1659306932058_180702.xml;type=text/xml'

ENTRADA

Parámetros de entrada
xml*

VALIDACIONES

Archivo no válido”
“Tipo de archivo no válido, favor proveer un XML

28

VALIDACIONES

FORMATOS

SALIDA

“La estructura del archivo XML no es válido, favor
proveer un XML con una estructura válida, verificar el
XSD correspondiente”
“La estructura del archivo XML no es válido, favor
proveer un XML con una estructura válida, verificar el
XSD correspondiente. {mensaje validación XSD}
“La firma del XML no es válida”
“El RNC del certificado no está delegado para realizar
transacciones para el RNC: {rncEmisor}".
“Factura no encontrada para esta Aprobación
comercial."
" Aprobación Comercial no es requerida para este tipo
de e‐CF"
" Aprobación Comercial no es requerida para el e‐CF
Referenciado"
"No se encuentra un e‐CF válido para esta aprobación
comercial"
"No fue posible procesar la Aprobación comercial.
Favor intentar nuevamente"

Respuesta en formato JSON

{

  "mensaje": [

    "string"

  ],

  "estado": "string",

  "codigo": "string"
}

Respuesta en formato XML

<?xml version="1.0" encoding="UTF-8"?>

<RespuestaAprobacionComercial>

<mensaje>string</mensaje>

<estado>string</estado>

<codigo>string</codigo>

</RespuestaAprobacionComercial>

29

DESCRIPCION

PARAMETROS

DE SALIDA

- mensaje: mensaje asociado al estado de validación de la

-

-

aprobación comercial recibida.
estado: estado de validación otorgado por Impuestos
Internos a la aprobación comercial recibida.
código: código asociado al estado de validación de la
aprobación comercial recibida..

ESTADOS

SALIDA

       Aprobación comercial aprobada (1): implica que la
       aceptación comercial del e-CF fue validado.
       Aprobación comercial rechazada (2): corresponde a
       que la factura no fue encontrada o que por alguna
       razón la aprobación comercial no pudo ser llevada a
       cabo satisfactoriamente.

Anulación de e‐NCF

Servicio web responsable de recibir y anular los rangos de secuencias no utilizados
(e‐NCF) a través de un XML de solicitud que contiene el código de comprobante
electrónico, una serie de rangos, desde y hasta, así como un token asociado a una
sesión válida.

En el caso de las Facturas de Consumo Electrónicas, se validará que no haya sido
utilizada para ninguna de las vías existentes con montos superior o inferior a los
RD$250,000.00, rechazándose la operación para aquellas que en efecto hayan sido
utilizadas y no pudiéndose utilizar posteriormente secuencias que si hayan podido ser
anuladas.

30

URLs del servicio

          TesteCF: Ambiente de pre-certificación:
         https://ecf.dgii.gov.do/testecf/anulacionrangos

         eCF: Ambiente de producción:
         https://ecf.dgii.gov.do/ecf/anulacionrangos

MÉTODOS Y PARÁMETROS

MÉTODO

POST

RECURSO

(ENDPOINT)

/api/operaciones/anularrango

REQUEST URL

https://ecf.dgii.gov.do/{ambiente}/anulacionrangos/api/operacio
nes/anularrango

  curl -X 'POST' \

'https://ecf.dgii.gov.do/testecf/anulacionrangos/api/Operacion
es/AnularRango' \

EJEMPLO CURL

  -H 'accept: application/json' \
  -H 'Authorization: bearer

eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJodHRwOi8vy50-ZnXSc
8ya1l8Yw' \

  -H 'Content-Type: multipart/form-data' \
  -F 'xml=@response_1659306932058_180702.xml;type=text
/xml'

ENTRADA

Parámetros de entrada
xml*

VALIDACIONES

         "Tipo de archivo no valido, favor proveer un XML".
         "La firma del documento no es válida".
         "El tipo de comprobante no es válido".
         "El valor del campoSecuenciaeNCFDesde es mayor al
         del campo SecuenciaeNCFHasta".
         "Las secuencias que está intentando anular han sido
         utilizadas".

31

VALIDACIONES

         "Las secuencias fueron anuladas correctamente. Con
         excepción de las secuencias del detalle".
         "El campo NoLinea no es válido, no cumple orden
         secuencial."
         "No fue posible anular las siguientes secuencias".
         "El RNC del certificado no está delegado para realizar
         transacciones para el RNC".

FORMATOS

SALIDA

Respuesta en formato JSON
                      {
                      "rnc": "string",
                      "codigo": "string",
                      "nombre": "string",
                      "mensajes": [
                       "string"
                      ]
                    }

Respuesta en formato XML
      <?xml version="1.0" encoding="UTF-8"?>
      <RespuestaAnulacionRango>
      <rnc>string</rnc>
      <codigo>string</codigo>
      <nombre>string</nombre>
      <mensajes>string</mensajes>
      </RespuestaAnulacionRango>

DESCRIPCION

PARAMETROS

DE SALIDA

-

-

rnc: número de registro nacional del contribuyente que envió
la anulación.
codigo: código asociado al resultado de la validación de la
anulación.

- Nombre: motivo del mensaje de validación de la anulación

recibida.

- Mensajes: mensaje asociado al resultado de la validación de

la anulación recibida.

32

Consulta Directorio de Servicios

Servicios web responsable de retornar en el ambiente productivo los contribuyentes
electrónicos autorizados y las URLs de sus servicios de recepción de eCF, aprobación
comercial y autenticación (Opcional).

En el caso de este servicio en el ambiente de pre-certificación, se retornarán las URLs
de prueba del servicio de emisor receptor habilitado por DGII para simular ser otro
contribuyente, permitiendo autenticarse, recibir y enviar comprobantes y/o
aprobaciones comerciales.

URLs del servicio

          TesteCF: Ambiente de pre-certificación:
         https://ecf.dgii.gov.do/testecf/consultadirectorio

         eCF: Ambiente de producción:
         https://ecf.dgii.gov.do/ecf/consultadirectorio

33

Métodos y parámetros

LISTADO DIRECTORIO

DESCRIPCIÓN

Retorna un listado de todos los contribuyentes electrónicos
autorizados y las URLs de sus servicios de recepción de eCF,
aprobación comercial y autenticación (Opcional).

METODO

GET

RECURSO

(ENDPOINT)

/api/consultas/listado

REQUEST URL

https://ecf.dgii.gov.do/{ambiente}/consultadirectorio/api
/consultas/listado

  curl -X 'GET' \

EJEMPLO CURL

'https://ecf.dgii.gov.do/testecf/consultadirectorio/api/Consultas/
Listado' \
  -H 'accept: application/json' \
  -H 'Authorization: bearer
eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJodH1h54bWxzb21l8Yw'

ENTRADA

Parámetros de entrada
N/A

FORMATOS

SALIDA

  Respuesta en formato JSON
[
{
"nombre": "string",
"rnc": "string",
"urlRecepcion": "string",
"urlAceptacion": "string"
"urlOpcional": "string"
}
]

34

DESCRIPCION

PARAMETROS

DE SALIDA

-

-

- Nombre: razón social del contribuyente.
-
-

rnc: número de registro nacional del contribuyente.
urlRecepcion: host del servicio de recepción del
contribuyente.
urlAceptacion host del servicio de aprobación comercial del
contribuyente.
urlOpcional: host del servicio de autenticación del
contribuyente, en caso de utilizarse.

DIRECTORIO POR RNC

DESCRIPCIÓN

Retorna las URLs de los servicios de recepción de eCF,
aprobación comercial y autenticación (Opcional) de un
contribuyente en particular, siempre y cuando este autorizado
como electrónico.

METODO

GET

RECURSO

(ENDPOINT)

/api/consultas/obtenerdirectorioporrnc

REQUEST URL

https://ecf.dgii.gov.do/{ambiente}/consultadirectorio/api
/consultas/obtenerdirectorioporrnc

  curl -X 'GET' \

EJEMPLO CURL

'https://ecf.dgii.gov.do/testecf/consultadirectorio/api/consultas/
obtenerdirectorioporrnc?RNC=xxxxxxxxx' \
  -H 'accept: application/json' \
  -H 'Authorization: bearer
eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJodH1h54bWxzb21l8Yw'

ENTRADA

Parámetros de entrada
RNC*

35

FORMATOS

SALIDA

DESCRIPCION

PARAMETROS

DE SALIDA

Respuesta en formato JSON
[
{
"nombre": "string",
"rnc": "string",
"urlRecepcion": "string",
"urlAceptacion": "string"
"urlOpcional": "string"
}
]

- Nombre: razón social del contribuyente.
-
-

rnc: número de registro nacional del contribuyente.
urlRecepcion: host del servicio de recepción del
contribuyente.
urlAceptacion host del servicio de aprobación comercial del
contribuyente.
urlOpcional: host del servicio de autenticación del
contribuyente, en caso de utilizarse.

-

-

Consulta timbre (QR)

Responsable de responder la validez de un e-CF remitido exclusivamente por el
servicio web de recepción de e‐CF, a partir de los datos incluidos en el timbre de su
representación impresa (RI).

URLs del servicio

          TesteCF: Ambiente de pre-certificación:
         https://ecf.dgii.gov.do/testecf/consultatimbre

         CerteCF: Ambiente de certificación:
         https://ecf.dgii.gov.do/certecf/consultatimbre

         eCF: Ambiente de producción:
         https://ecf.dgii.gov.do/ecf/consultatimbre

36

PARÁMETROS

EJEMPLO

PARÁMETROS, RESPUESTA Y OTROS DATOS

Parámetros a concatenar

RncEmisor
RncComprador
ENCF
FechaEmision

         MontoTotal
FechaFirma
CodigoSeguridad

Ejemplo URL construida (Dirección de Host + Parámetros):

https://ecf.dgii.gov.do/testecf/consultatimbre?rncemisor=130
000001&rnccomprador=130000002&encf=e310000000001&f
echaemision=10-10-2020&montototal=02.11&fechafirma=10-
10-2020%2009:00:00&codigoseguridad=dcp79q

Esta URL es la que se espera al leer el QR de la RI de un e-CF.

VERSIÓN

Se utilizará la versión 8 de código QR para la representación
impresa: https://www.qrcode.com/en/about/version.html.

SALIDA

          RNC Emisor
          Razón social emisor
RNC Comprador
Razón social comprador
e-NCF

Fecha de Emisión
Total de ITBIS
Monto Total
Estado

DESCRIPCION

PARAMETROS

DE SALIDA

-

- RNC Emisor: número de registro nacional del

contribuyente que emitió el e-CF.

- Razón social emisor: razón social del contribuyente que

emitió el e-CF.

- RNC Comprador: extraído del e-CF recibido (Si aplica).
- Razón social comprador: extraído del e-CF recibido (Si

aplica).
e-NCF: número de secuencia utilizada por el
contribuyente, extraído del e-CF.
Fecha de Emisión: extraído del e-CF.

-
- Total de ITBIS: extraído del e-CF.
- Monto Total: extraído del e-CF.
- Estado: estado de validación otorgado por Impuestos

Internos al e-CF recibido

37

ESTADOS

SALIDA

No fue encontrada la factura (e-CF): corresponde a
que el e-CF no se encontró en la base de datos de la
DGII.
Aceptado: implica la validez del e‐CF de la RI,
incluyendo el aceptado condicional que corresponde a
que no cumplió en algún punto pero que no amerita el
rechazo de este.
Rechazado: corresponde a que el e-CF de la RI le fue
rechazado al emisor.

Consulta timbre FC (QR).

Responsable de responder la validez de un Resumen de Factura de Consumo
Electrónica remitida exclusivamente por el servicio web de recepción FC, con un monto
inferior a los RD$250,000.00 a partir de los datos incluidos en el timbre de su
representación impresa (RI).

URLs del servicio

TesteCF: Ambiente de pre-certificación:
https://fc.dgii.gov.do/testecf/consultatimbrefc

eCF: Ambiente de producción:
https://fc.dgii.gov.do/ecf/consultatimbrefc

PARÁMETROS, RESPUESTA Y OTROS DATOS

PARÁMETROS

Parámetros a concatenar

RNCEmisor
e-NCF
MontoTotal
CódigoSeguridad

38

Ejemplo URL construida (Dirección de Host + Parámetros):

EJEMPLO

https://fc.dgii.gov.do/testecf/consultatimbrefc?rncemisor=13
1880738&encf=e320000000064&montototal=6225.09&codig
oseguridad=uabnyh

Esta URL es la que se espera al leer el QR de la RI de un RFCE.

VERSIÓN

Se utilizará la versión 8 de código QR para la representación
impresa: https://www.qrcode.com/en/about/version.html.

SALIDA

         RNC Emisor

Razón Social
e-NCF
Estado

DESCRIPCION

PARAMETROS

DE SALIDA

-

- RNC Emisor: número de registro nacional del

contribuyente que emitió el resumen de factura de
consumo.

- Razón Social: razón social del contribuyente que emitió el

resumen de factura de consumo.
e-NCF: número de secuencia utilizada por el
contribuyente, extraído del resumen de factura de
consumo.

- Estado: estado de validación otorgado por por Impuestos

Internos al resumen de factura de consumo recibido.

No fue encontrada la factura (e-CF): corresponde a que
el e-CF no se encontró en la base de datos de la DGII.
Aceptado: implica la validez del e‐CF de la RI,
incluyendo el aceptado condicional que corresponde a
que no cumplió en algún punto pero que no amerita el
rechazo de este.
Rechazado: corresponde a que el e-CF de la RI le fue
rechazado al emisor.

ESTADOS

SALIDA

39

Comunicación Emisor-Receptor

Servicio web responsable de simular ser un contribuyente y a partir de esto permitir a
otros contribuyentes interactuar entre si a modo de establecer comunicación como
debe ser realizado en el ambiente productivo.

URLs del servicio

          TesteCF: Ambiente de pre-certificación:
         https://ecf.dgii.gov.do/testecf/emisorreceptor

Endpoints, Métodos y parámetros

Dentro de la URL, se encontrarán los siguientes recursos (Endpoint):

AUTENTICACIÓN: SEMILLA

DESCRIPCIÓN

Retorna un archivo semilla (en formato XML) que deberá ser
firmado para obtener un token mediante el método POST.

MÉTODO

GET

RECURSO

(ENDPOINT)

/fe/autenticacion/api/semilla

REQUEST URL

https://ecf.dgii.gov.do/testecf/emisorreceptor/fe/autenticacion/a
pi/semilla

SALIDA

Respuesta en formato XML
<?xml version="1.0" encoding="utf‐8"?>
<SemillaModel
xmlns:xsi="http://www.w3.org/2001/XMLSchema‐instance"
xmlns:xsd="http://www.w3.org/2001/XMLSchema">
<valor>0000000‐0000‐0000‐0000‐000000000000</valor>
<fecha>2019‐03‐13T14:33:32.8617792‐04:00</fecha>
</SemillaModel>

40

AUTENTICACIÓN: VALIDACION CERTIFICADO

DESCRIPCIÓN

Permite el envío del archivo (Semilla) firmado y retorna un objeto
que contiene un string de autenticación (token) asociado a una
fecha de emisión y una fecha de expiración.

MÉTODO

POST

RECURSO

(ENDPOINT)

/fe/autenticacion/api/validacioncertificado

REQUEST URL

https://ecf.dgii.gov.do/testecf/emisorreceptor/fe/autenticacion/a
pi/validacioncertificado

VALIDACIONES

Estructura del XML valida (No alterada).
Formato de archivo valido.
Parámetro de entrada requerido haya sido completado.
RNC del token autorizado.

ENTRADA

Parámetro
*xml

Respuesta en formato JSON
{
  "token": "string",
  "expira": "2022-07-19T19:14:48.237Z",
  "expedido": "2022-07-19T19:14:48.237Z"
}

SALIDA

Respuesta en formato XML
<?xml version="1.0" encoding="UTF-8"?>
<RespuestaAutenticacion>

<token>string</token>
<expira>2022-07-19T19:15:06.893Z</expira>
<expedido>2022-07-19T19:15:06.893Z</expedido>

</RespuestaAutenticacion>

Ver RCF 6750 (https://tools.ietf.org/html/rfc6750) para más información sobre la
autenticación por tokens.

41

EMISIÓN: COMPROBANTES

DESCRIPCIÓN

Envía a modo de simulación, el tipo de comprobante electrónico
(eCF) deseado en XML a la URL del servicio de recepción
especificado por el contribuyente, autenticándose previamente en
caso de haber especificado dicha URL.

MÉTODO

POST

RECURSO

(ENDPOINT)

/api/emision/emisioncomprobantes

REQUEST URL

https://ecf.dgii.gov.do/testecf/emisorreceptor/api/emision/emisi
oncomprobantes

VALIDACIONES

Tipo de comprobantes 32, 41, 43, 45, 46 y 47 no aplican
para ser enviados a otro contribuyente.
Parámetros de entrada válidos.
Parámetros de entrada requeridos hayan sido completados.
RNC del token autorizado.

ENTRADA

Formato JSON
{
  "rnc": "string",
  "tipoEncf": "string",
  "urlRecepcion": "string",
  "urlAutenticacion": "string"
}
Formato XML
<?xml version="1.0" encoding="UTF-8"?>
<EmisionComprobanteModel>
<rnc>string</rnc>
<tipoEncf>string</tipoEncf>
<urlRecepcion>string</urlRecepcion>
<urlAutenticacion>string</urlAutenticacion>

</EmisionComprobanteModel>

SALIDA

XML de un eCF

42

EMISIÓN: CONSULTA DE ACUSE

DESCRIPCIÓN

Permite consultar el estado de validación del acuse retornado por
el contribuyente en respuesta al comprobante que se le fue
enviado mediante el endpoint EmisionComprobantes.

MÉTODO

GET

RECURSO

(ENDPOINT)

/api/emision/consultaacuserecibo

REQUEST URL

https://ecf.dgii.gov.do/testecf/emisorreceptor/api/emision
/consultaacuserecibo

VALIDACIONES

Parámetros de entrada válidos.
Parámetros de entrada requeridos hayan sido completados.
RNC del token autorizado.

ENTRADA

Parámetros de entrada
Rnc: string
Encf: string

Formato JSON
{
  "rnc": "string",
  "encf": "string",
  "estado": "string",
  "mensajes": [
    "string"
  ]
}

SALIDA

Formato XML
<?xml version="1.0" encoding="UTF-8"?>
<RespuestaConsultaAcuseRecibo>

<rnc>string</rnc>
<encf>string</encf>
<estado>string</estado>
<mensajes>string</mensajes>

</RespuestaConsultaAcuseRecibo>

43

EMISIÓN: APROBACIÓN COMERCIAL

DESCRIPCIÓN

Envía a modo de simulación, una aprobación comercial en XML
referenciado a un eNCF deseado a la URL del servicio
especificado por el contribuyente, autenticándose previamente en
caso de haberse especificado dicha URL.

MÉTODO

POST

RECURSO

(ENDPOINT)

/api/emision/envioaprobacioncomercial

REQUEST URL

https://ecf.dgii.gov.do/testecf/emisorreceptor/api/emision/envio
aprobacioncomercial

VALIDACIONES

Aprobaciones comerciales para los tipos de eCF 32, 41, 43,
46 y 47 no aplican para ser enviadas a otro contribuyente.
Parámetros de entrada válidos.
Parámetros de entrada requeridos hayan sido completados.
RNC del token autorizado.

ENTRADA

Formato JSON
{
  "urlAprobacionComercial": "string",
  "urlAutenticacion": "string",
  "rnc": "string",
  "encf": "string",
  "estadoAprobacion": "string"
}
Formato XML
<?xml version="1.0" encoding="UTF-8"?>
<EnvioAprobacionComercialModel>
<urlAprobacionComercial>string</urlAprobacionComercial>

<urlAutenticacion>string</urlAutenticacion>
<rnc>string</rnc>
<encf>string</encf>
<estadoAprobacion>string</estadoAprobacion>

</EnvioAprobacionComercialModel>

SALIDA

XML de una Aprobación Comercial

44

RECEPCIÓN: COMPROBANTES

DESCRIPCIÓN

Recibe a modo de simulación, un comprobante electrónico
(eCF) y en respuesta retorna un acuse de recibo de este.

MÉTODO

POST

RECURSO

(ENDPOINT)

/fe/recepcion/api/ecf

REQUEST URL

https://ecf.dgii.gov.do/testecf/emisorreceptor/fe/recepcion/api/
ecf

Tipo de comprobantes 32, 41, 43, 45, 46 y 47 no aplican
para ser enviados a otro contribuyente.

VALIDACIONES

Formato de archivo válido.

Estructura del XML válido (XSD).

Firma digital del XML válido.

Parámetro de entrada requerido haya sido completado.

RNC del token autorizado.

ENTRADA

Parámetro de entrada
XML de un eCF

SALIDA

XML de un Acuse de Recibo

45

RECEPCIÓN: APROBACIÓN COMERCIAL

DESCRIPCIÓN

Recibe a modo de simulación, una aprobación comercial y en
respuesta retorna un 200 o 400 según la satisfacción.

MÉTODO

POST

RECURSO

(ENDPOINT)

/fe/aprobacioncomercial/api/ecf

REQUEST URL

https://ecf.dgii.gov.do/testecf/emisorreceptor/fe
/aprobacioncomercial/api/ecf

Aprobaciones comerciales para los tipos de eCF 32, 41,
43, 46 y 47 no aplican para ser enviadas a otro
contribuyente.

VALIDACIONES

Formato de archivo válido.

Estructura del XML válido (XSD).

Firma digital del XML válido.

Parámetro de entrada requerido haya sido completado.

RNC del token autorizado.

ENTRADA

Parámetro de entrada
XML de una aprobación comercial

SALIDA

HTTP 200: Satisfactorio
HTTP 400: Insatisfactorio

46

Estatus Servicios

Servicio web responsable de proporcionar el estatus y disponibilidad de los servicios
de facturación electrónica, como también las ventanas de mantenimientos de estos.

URLs del servicio

 Ambiente de producción:  https://statusecf.dgii.gov.do/

Métodos y parámetros

Dentro de la URL, se encontrarán los siguientes tres (3) recursos (Endpoint):

OBTENER ESTATUS

Retorna una lista de los servicios del ambiente de precertificación
y producción con su respectivo estatus.

DESCRIPCION

Este servicio cuenta con una clave única (APIKEY) para la
autorización de su uso, el cual es entregado por la autoridad
tributaria cuando se cumplen ciertos requisitos.

47

MÉTODO

GET

RECURSO

(ENDPOINT)

/api/estatusservicios/obtenerestatus

REQUEST URL

https://statusecf.dgii.gov.do/api/estatusservicios/obtenerestatus

EJEMPLO CURL

curl -X 'GET' \
'https://statusecf.dgii.gov.do/api/estatusservicios/obtenerestatus' \

-H 'accept: */*' \
-H 'Authorization: Apikey XXXXXXX-XXXXXXX-XXXX-XXXXXXXXXX'

SALIDA

Respuesta en formato JSON
[
  {
    "servicio": "Autenticación",
    "estatus": "Disponible",
"ambiente": "Produccion"

  },
  {
    "servicio": "Recepción",
    "estatus": "Disponible",
"ambiente": "Produccion"

  },
  {
    "servicio": "Consulta Resultado",
    "estatus": "Disponible",
"ambiente": "Produccion"

  },
  {
    "servicio": "Consulta Estado",
    "estatus": "Disponible",
"ambiente": "Produccion"

  },
  {
    "servicio": "Consulta Directorio",

48

SALIDA

"estatus": "Disponible",
"ambiente": "Produccion"

  },
  {
    "servicio": "Consulta TrackIds",
    "estatus": "Disponible",
"ambiente": "Produccion"

  },
  {
    "servicio": "Aprobación Comercial",
    "estatus": "Disponible",
"ambiente": "Produccion"

  },
  {
    "servicio": "Anulación Rangos",
    "estatus": "Disponible",
"ambiente": "Produccion"

  },
  {
    "servicio": "Recepción FC",
    "estatus": "Disponible",
"ambiente": "Produccion"

  }
]

49

OBTENER VENTANAS MANTENIMIENTO

DESCRIPCION

Retorna una lista de los días de las ventanas de mantenimientos
de los servicios de facturación de electrónica.

MÉTODO

GET

RECURSO

(ENDPOINT)

/api/estatusservicios/obtenerventanasmantenimiento

REQUEST URL

https://statusecf.dgii.gov.do/api/estatusservicios/obtenerventana
smantenimiento

EJEMPLO CURL

curl -X 'GET' \
'https://statusecf.dgii.gov.do/api/estatusservicios/obtenerventanas
mantenimiento' \
  -H 'accept: */*' \
  -H 'Authorization: Apikey XXXXXXX-XXXXXXX-XXXX-XXXXXXXXXX'

SALIDA

Respuesta en formato JSON
{
  "ventanaMantenimientos": [
    {
      "ambiente": "PreCertificacion",
      "horaInicio": "9:00 AM",
      "horaFin": "12:00 PM",
      "dias": [
        "06-08-2020",
        "20-08-2020",
        "10-09-2020",
        "22-09-2020"
      ]
    },
    {
      "ambiente": "Produccion",
      "horaInicio": "1:00 PM",
      "horaFin": "4:00 PM",
      "dias": [
        "06-08-2020",
        "20-08-2020",
        "10-09-2020",
"22-09-2020"

50

SALIDA

      ]
    },
{
      "ambiente": "Certificacion",
      "horaInicio": "1:00 PM",
      "horaFin": "4:00 PM",
      "dias": [
        "06-08-2020",
        "20-08-2020",
        "10-09-2020",
        "22-09-2020"
      ]
    }
  ]
}

VERIFICAR ESTADO

DESCRIPCION

Retorna si los servicios de facturación de electrónica se
encuentran en ventana de mantenimiento. Estatus =
“Disponible” significa que los servicios no están en
mantenimiento y “No Disponible” es que los servicios se
encuentran en mantenimiento.

MÉTODO

GET

RECURSO

(ENDPOINT)

/api/estatusservicios/verificarestado

GET

https://statusecf.dgii.gov.do/api/estatusservicios/verificarestad
o?ambiente=1

ENTRADA

SALIDA

Parámetro Ambiente:

1: PreCertificacion

2: Producción

3: Certificación

Respuesta en formato JSON
{
  "estado": "Disponible"
}

51

Estándar de comunicación Emisor ‐ Receptor

Con el objetivo de garantizar el intercambio seguro de información entre
contribuyentes, en la presente sección se describe el estándar de comunicación que
estos deberán tener para Facturación Electrónica.

Requerimientos Generales

1
1

2

3

4

5

6

7

Desarrollar o adquirir un software especializado que permita la generación,
emisión y recepción de e-CF y aprobaciones comerciales.

Trabajar sobre SSL (usar HTTPs).

Uso de REST API para la comunicación.

Uso de puertos de red tradicionales.

Servicios no sensitivos a mayúsculas y minúsculas.

Servicios alcanzarse a través internet de manera pública y siempre disponibles.

Contar con un certificado digital de persona física para procesos tributarios
emitido por una entidad de certificación autorizada por INDOTEL y DGII.

Creación y Parametrización De Servicios

Los contribuyentes deberán crear los siguientes servicios con el estándar definido para
el nombre de los endpoint, de manera que la única diferencia entre los servicios de los
contribuyentes sea la dirección de host:

          URL de autenticación, servicio web responsable de establecer protección y

control a la interacción de los servicios entre contribuyentes, su uso es opcional,
no obstante, es recomendado antes de generar una sesión.

Autenticacion*

52

https://EstándarEstándarDirección de Host /fe/autenticacionEn caso de utilizarse autenticación, el servicio debe contar con los siguientes dos recursos (endpoint):https:///fe/autenticacion/api/[semilla/validacioncertificado]ESPECIFICACIONES AUTENTICACIÓN: SEMILLA

Retorna un archivo XML con un valor único (Semilla) que
posteriormente tendrá que ser firmado digitalmente para ser
intercambiado por un token (ver próximo endpoint).

/fe/autenticacion/api/semilla

DESCRIPCION

ESTÁNDAR

RECURSO

(ENDPOINT)

MÉTODO

GET

PARÁMETROS

DE ENTRADA

N/A.

EJEMPLO

HEADER

curl -X 'GET' \
'https://host/ambiente/nombreservicio/fe/autenticacion/api/semil
la' \
  -H 'accept: application/json'

SALIDA

XML

Respuesta en formato XML
<?xml version="1.0" encoding="utf-8"?>
  <SemillaModel
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xmlns:xsd="http://www.w3.org/2001/XMLSchema">

EJEMPLO

SALIDA

<valor>0XgGeOL2rFxxmt22g4abxa91yCXBlmyeci6H1+519R
uDfCIuqf2YtD7Wdftm1m1z39G4YobDwvD2iieTwua3Sopo6I
zTphHwBPNfim/AzEnHh0GQew/5BHrAGf2+KjddTDOw7mc7
hQcsmgfBg7drWg==</valor>

<fecha>2022-07-27T11:59:31.3551245-04:00</fecha>

 </SemillaModel>

53

ESPECIFICACIONES AUTENTICACIÓN: VALIDACIONCERTIFICADO

DESCRIPCION

Valida la firma del archivo semilla entregado.

ESTÁNDAR

RECURSO

(ENDPOINT)

/fe/autenticacion/api/validacioncertificado

MÉTODO

POST

PARÁMETROS

DE ENTRADA

XML

EJEMPLO

HEADER

curl -X 'POST' \
'https://host/ambiente/nombreservicio/fe/autenticacion/api/
validacioncertificado' \
  -H 'accept: application/json' \
  -H 'Content-Type: multipart/form-data' \
  -F 'xml=@ArchivoSemillaFirmado.xml;type=text/xml'

SALIDA

Un token con su fecha de expedición y expiración,
pudiendo solicitarse dicha respuesta en formato JSON o
XML según el consumidor lo especifique en el accept del
header de su petición.
Dichas fechas deben encontrarse en el formato estándar
universal yyyy-MM-ddTHH:mm:ssZ, ver referencia:
https://docs.microsoft.com/en-us/dotnet/api/system.glob
alization.datetimeformatinfo.universalsortabledatetimepatt
ern?view=net-6.0
Adicionalmente, ver la siguiente referencia para más
información sobre la autenticación por tokens:
Ver RCF 6750 (https://tools.ietf.org/html/rfc6750).

54

Respuesta en formato JSON
                      {
"token": "string",

"expira": "yyyy-MM-ddTHH:mm:ssZ",
"expedido": "yyyy-MM-ddTHH:mm:ssZ"
}
Respuesta en formato XML
                 <?xml version="1.0" encoding="UTF‐8"?>

EJEMPLO

SALIDA

<RespuestaAutenticacion>
<token>string</token>
 <expira> yyyy-MM-ddTHH:mm:ssZ</expira>
 <expedido> yyyy-MM-ddTHH:mm:ssZ</expedido>
                                 </RespuestaAutenticacion>

          URL de recepción, servicio web que recibirá el archivo XML de los e‐CF que

le sean emitidos.

Recepción*

ESPECIFICACIONES RECEPCIÓN

ESTÁNDAR

RECURSO

(ENDPOINT)

/fe/recepción/api/ecf

MÉTODO

POST

PARÁMETROS

DE ENTRADA

XML (Formato e-CF)

55

https://EstándarEstándarDirección de Host /fe/recepción/api/ecf

AUTHORIZA

TION

Un header Authorization con el esquema Bearer y el valor del
token obtenido en la autenticación, condicional a que se haya
declarado autenticación.

EJEMPLO

HEADER

curl -X 'POST' \
'https://host/ambiente/nombreservicio/fe/recepcion/api/e
cf'\
  -H 'accept: */*' \
  -H 'Authorization: bearer
eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJodHRwOi8vc2NoZ
W1hcy54bWxzb2FwLm9yZy93cy8yMDA1LzA1L2lkZW50aXR
5L2NsYWltcy9uYW1lIjoiMDAxOTk5OTk5OTYiLCJqdGkiOiI2
MzhjZDdjNS0xY2NlLTQyMmUtYjNkMC0wMGQ4MTczMzYxN
WUiLCJuYmYiOjE2NTkzMDY5NzIsImV4cCI6MTY1OTMxMDU
3MiwiaXNzIjoiREdJSS5GRSIsImF1ZCI6IlVTVUFSSU9TLkRHSUk
uRkUifQ.4qk1-0iqWkXcBC-n_JTEYoeniie90-ZnXSc8ya1l8Yw'
\
  -H 'Content-Type: multipart/form-data' \
  -F 'xml=@101672919E3100000001.xml;type=text/xml'

SALIDA

Un XML de acuse de recibo firmado digitalmente.

EJEMPLO

SALIDA

Respuesta en formato XML
<?xml version="1.0" encoding="utf-8"?>
<ARECF
xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
xmlns:xsd="http://www.w3.org/2001/XMLSchema">
  <DetalleAcusedeRecibo>
    <Version>1.0</Version>
    <RNCEmisor>131880600</RNCEmisor>
    <RNCComprador>132880600</RNCComprador>
    <eNCF>E310000000001</eNCF>
    <Estado>0</Estado>
    <FechaHoraAcuseRecibo>17-12-2020
11:19:06</FechaHoraAcuseRecibo>
  </DetalleAcusedeRecibo>
</ARECF>

Nota: tomar de referencia el formato y XSD compartido en
el portal.

56

         URL de aprobación comercial, servicio web que recibirá el archivo XML de las

aprobaciones comerciales que se le sean emitidas.

Aprobación Comercial*

ESPECIFICACIONES APROBACIÓN COMERCIAL

MÉTODO

POST

PARÁMETROS

DE ENTRADA

XML (Formato ACECF)

AUTHORIZA

TION

Un header Authorization con el esquema Bearer y el valor del
token obtenido en la autenticación, condicional a que se haya
declarado autenticación.

EJEMPLO

HEADER

curl -X 'POST' \
'https://host/ambiente/nombreservicio/fe/aprobacioncomercia
l/api/ecf' \
  -H 'accept: */*' \
  -H 'Authorization: bearer
eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJodHRwOi8vc2NoZW1h
cy54bWxzb2FwLm9yZy93cy8yMDA1LzA1L2lkZW50aXR5L2NsY
Wltcy9uYW1lIjoiMDAxOTk5OTk5OTYiLCJqdGkiOiI2MzhjZDdjNS
0xY2NlLTQyMmUtYjNkMC0wMGQ4MTczMzYxNWUiLCJuYmYiOj
E2NTkzMDY5NzIsImV4cCI6MTY1OTMxMDU3MiwiaXNzIjoiREdJS
S5GRSIsImF1ZCI6IlVTVUFSSU9TLkRHSUkuRkUifQ.4qk1-0iqWkXc
BC-n_JTEYoeniie90-ZnXSc8ya1l8Yw' \
  -H 'Content-Type: multipart/form-data' \
  -F 'xml=@101672919E3100000001.xml;type=text/xml'

SALIDA

Satisfactorio: HTTP 200
Insatisfactorio: HTTP 400

57

https://EstándarEstándarDirección de Host/fe/aprobacioncomercial/api/ecfRestricciones de Contenido y/o Caracteres en los XML

En la información ‘ALFANUM’ dentro de los XML, los siguientes caracteres no deben
emplearse, ya que tienen un significado por sí solos y deberán ser remplazados por
definiciones estándar especificadas a continuación:

Nombre

Carácter

Referencia Decimal

Referencia Hexadecimal

quot

amp

apos

It

gt

“ ”

&

‘

<

>

&#34;

&#38;

&#39;

&#60;

&#62;

&#x22;

&#x26;

&#x27;

&#x3C;

&#x3E;

En el caso de los datos del código de seguridad del QR en las representaciones
impresas, a su vez no deben utilizarse los siguientes caracteres reservados ya que
tienen un significado especial en la URL y deberán ser reemplazados en esta por su
representación hexadecimal.

Nombre

Espacio

Cierra admiración

Numeral

Pesos (dólar)

Et
(ampersand)

Apóstrofo

Paréntesis izquierdo

Paréntesis derecho

Asterisco

Más

Coma

Barra

Dos puntos

Punto y coma

Carácter

Referencia Hexadecimal

%20;

%21

%23

%24

%26

%27

%28

%29

%2A

%2B

%2C

%2F

%3A

%3B

!

#

$

&

'

(

)

*

+

,

/

:

;

58

Igual

Cierra interrogación

Arroba

Corchete izquierdo

Corchete derecho

Comilla

Guión

Punto

Menor

Mayor

Barra inversa

Acento circunflejo

Guión bajo

Tilde grave

=

?

@

[

]

"

-

.

<

>

\

^

_

`

%3D

%3F

%40

%5B

%5D

%22

%2D

%2E

%3C

%3E

%5C

%5E

%5F

%60

Adicionalmente, no deberá incluirse en los XML tags vacíos, todo tag que no vaya a ser
utilizado debe excluirse de los eCF o de lo contrario provocará un rechazo debido a
que su evaluación sin ningún tipo de valor afecta el tiempo de validación.

Formato de Nombre de los Archivos XML

Los contribuyentes deberán utilizar el siguiente estándar para el nombre de los
archivos de cada formato XML a emitir, con el objetivo de tener una mejor gestión
física de estos:

Formato XML

Nombre de archivo

Ejemplo

Formato e-CF

RNCEmisor+e-NCF

101672919E3100000001.xml

Formato Aprobación
Comercial

RNCComprador+e-NCF

101672919E3100000001.xml

Formato Acuse de recibo

RNCComprador +e-NCF

101672919E3100000001.xml

Formato de Resumen
Factura de Consumo
(32 < 250,000.00)

RNCEmisor+e-NCF

101672919E3200000001.xml

%5B

59

Firmado de XML

En el firmado de los XML, se deben tomar en cuenta los siguientes puntos:

• El protocolo de firmado a utilizar es SHA-256.
• El campo “SN” de los certificados digitales debe corresponder al RNC, Cedula o

Pasaporte del propietario del certificado.

• Debe realizarse la firma sin la preservación de los espacios preservewhitespace

= false.

• Una vez firmado el XML, este no puede ser alterado en ninguna circunstancia.

Recomendaciones

1) A la hora de enviar e-CF o aprobación comercial a la autoridad tributaria u otro

contribuyente, siempre verificar que las URL se encuentren correctas, para evitar
inconvenientes de recepción.

2) Cumplir con el estándar para los servicios para evitar escenarios de comunicación.
3) Familiarizarse con las validaciones de los formatos (XML) para todas las

operaciones.

4) Tener en cuenta a la hora de enviar a la autoridad tributaria comprobantes tipo 32
que existen dos servicios de recepción según el monto de la factura, especificados
con más detalle en el apartado descripción de servicios.

5) Tener en cuenta a la hora de realizar la representación impresa de los e-CF, que
existen dos consultas timbre con variación de uso para los tipos 32 especificado
con más detalle en el apartado descripción de servicios.

6) A la hora de consultar el estado de validación de un e-CF a través del servicio de
consulta estado siempre confirmar que previamente haya sido autorizado por el
emisor o receptor como delegado.

7) Implementar autenticación para el uso de sus servicios es opcional para los

contribuyentes, sin embargo, se sugiere:

• Utilizar servicios web autenticados.
• Variar el valor de la semilla que retorna el endpoint GET de autenticación.
• Verificar que el archivo proporcionado mediante el endpoint semilla coincida

con el archivo proporcionado en el endpoint de validación de certificado.

60

dgii.gov.do

(809) 689-3444 desde todo el país.
(809) 689-0131 Quejas y Sugerencias.

informacion@dgii.gov.do

IMPUESTOS INTERNOS
Versión 1.5 | Mayo 2023

Publicación informativa sin validez legal

@DGII

