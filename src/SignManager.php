<?php

namespace PlatinumPlace\DgiiXmlSigner;

use Selective\XmlDSig\Algorithm;
use Selective\XmlDSig\CryptoSigner;
use Selective\XmlDSig\PrivateKeyStore;

/*
Descargar la librería XMLDSIG desde https://github.com/selective-php/xmldsig
Probado en las versiones de php 8.1.12 y 8.1.13
*/

/*
Nota:
**Refactorizaciones al archivo XmlSigner.php
al instanciar la clase DOMDocument coloque la propiedad preserveWhiteSpace a false debido a 
que los espacios en blanco no deben ser preservados
Existe otra función que recibe un DOMDocument recuerde ajustar este valor antes de enviar el 
objeto.
 $xml->preserveWhiteSpace = true;  cambiar a   $xml->preserveWhiteSpace = false;
 **Por otro lado
 $canonicalData = $element->C14N(true, false); cambiar a $canonicalData = 
$element->C14N(false, false);
 puede dejarlos sin parámetros puesto que sus valores por defecto son false, es decir puede ser 
=> $canonicalData = $element->C14N()
 **En la función appendSignature puede comentar las líneas 154 hasta la 170, los tag KeyValue, 
RSAKeyValue, Exponent no son necesarios
 **Recuerde habilitar la extensión openssl en su archivo php.ini, en algunas distribuciones esta 
deshabilitado por defecto.
*/
final class SignManager
{
    /**
     * The constructor.
     *
     * @param string $cert_store contenido del archivo p12
     * @param string $password contraseña para acceder a la información contenida en el certificado
     * @param string $xml contenido del archivo xml
     */
    public function sing(string $cert_store, string $password, string $xml): string
    {
        if (! openssl_pkcs12_read($cert_store, $certs, $password)) {

            echo "Error: No fue posible leer el contenido del certificado.\n";
            exit;
        }
        $pem_file_contents = $certs['cert'].$certs['pkey'];

        $privateKeyStore = new PrivateKeyStore;

        $privateKeyStore->loadFromPem($pem_file_contents, $password);

        $privateKeyStore->addCertificatesFromX509Pem($pem_file_contents);

        $algorithm = new Algorithm(Algorithm::METHOD_SHA256);

        $cryptoSigner = new CryptoSigner($privateKeyStore, $algorithm);

        $xmlSigner = new XmlSigner($cryptoSigner);

        $xmlSigner->setReferenceUri('');

        $signedXml = $xmlSigner->signXml($xml);

        return $signedXml;
    }
}
