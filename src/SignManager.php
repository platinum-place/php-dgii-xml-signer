<?php

namespace PlatinumPlace\DgiiXmlSigner;

use DOMDocument;
use Selective\XmlDSig\Algorithm;
use Selective\XmlDSig\CryptoSigner;
use Selective\XmlDSig\CryptoVerifier;
use Selective\XmlDSig\Exception\XmlSignatureValidatorException;
use Selective\XmlDSig\PrivateKeyStore;
use Selective\XmlDSig\PublicKeyStore;

/*
Descargar la librería XMLDSIG desde https://github.com/selective-php/xmldsig
Probado en las versiones de php 8.1.12 y 8.1.13
*/
/*
Nota:
**Refactorizaciones al archivo XmlSigner.php
al instanciar la clase DOMDocument coloque la propiedad preserveWhiteSpace a false debido a
que los espacios en blanco no deben ser preservados Existe otra función que recibe un DOMDocument recuerde ajustar este valor antes de enviar el
objeto.
 $xml->preserveWhiteSpace = true; cambiar a $xml->preserveWhiteSpace = false;
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
     * @param string $password contraseña para acceder a la información contenida en el
    certificado
     * @param string $xml contenido del archivo xml
     */
    public function sign(string $cert_store, string $password, string $xml): string
    {
        return $this->sing($cert_store, $password, $xml);
    }

    public function validateCertificate(string $cert_store, string $password): array
    {
        if (!openssl_pkcs12_read($cert_store, $certs, $password)) {
            throw new \RuntimeException('No fue posible leer el contenido del certificado.');
        }

        return $certs;
    }

    public function sing(string $cert_store, string $password, string $xml): string
    {
        $certs = $this->validateCertificate($cert_store, $password);

        $pem_file_contents = $certs['cert'] . $certs['pkey'];

        $privateKeyStore = new PrivateKeyStore();
        $privateKeyStore->loadFromPem($pem_file_contents, $password);
        $privateKeyStore->addCertificatesFromX509Pem($pem_file_contents);

        $algorithm = new Algorithm(Algorithm::METHOD_SHA256);
        $cryptoSigner = new CryptoSigner($privateKeyStore, $algorithm);

        $xmlSigner = new XmlSigner($cryptoSigner);
        $xmlSigner->setReferenceUri('');

        return $xmlSigner->signXml($xml);
    }

    public function verifyXmlSignature(string $xmlContent): void
    {
        $doc = new DOMDocument();
        $doc->preserveWhiteSpace = false;
        $doc->formatOutput = false;

        if (! $doc->loadXML($xmlContent)) {
            throw new XmlSignatureValidatorException('No se pudo cargar el XML.');
        }

        $publicKeyStore = new PublicKeyStore();
        $publicKeyStore->loadFromDocument($doc);

        $cryptoVerifier = new CryptoVerifier($publicKeyStore);

        $signatureVerifier = new XmlSignatureVerifier($cryptoVerifier, false);

        if (! $signatureVerifier->verifyXml($xmlContent)) {
            throw new XmlSignatureValidatorException("No es posible leer el contenido del certificado. Verifique la contraseña o la configuración 'legacy' de OpenSSL.");
        }
    }
}
