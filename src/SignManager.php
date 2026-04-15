<?php

namespace PlatinumPlace\DgiiXmlSigner;

use PlatinumPlace\DgiiXmlSigner\Exception\DgiiXmlSignerException;
use Selective\XmlDSig\Algorithm;
use Selective\XmlDSig\CryptoSigner;
use Selective\XmlDSig\PrivateKeyStore;

/**
 * Manager para gestionar el firmado de XML conforme a los requerimientos de la DGII.
 * Basado en las guías oficiales para e-CF en República Dominicana.
 */
final class SignManager
{
    /**
     * Alias del método sing() para mayor claridad.
     * 
     * @param string $cert_store Contenido del archivo .p12
     * @param string $password Contraseña del certificado
     * @param string $xml Contenido XML a firmar
     * @return string XML firmado
     */
    public function sign(string $cert_store, string $password, string $xml): string
    {
        return $this->sing($cert_store, $password, $xml);
    }

    /**
     * Firma el XML siguiendo la nomenclatura sugerida por la DGII.
     *
     * @param string $cert_store Contenido del archivo .p12
     * @param string $password Contraseña para acceder al certificado
     * @param string $xml Contenido del archivo XML
     * @return string XML firmado
     * @throws DgiiXmlSignerException Si el certificado no es válido o hay un error en el proceso
     */
    public function sing(string $cert_store, string $password, string $xml): string
    {
        if (!openssl_pkcs12_read($cert_store, $certs, $password)) {
            throw new DgiiXmlSignerException("Error: No fue posible leer el contenido del certificado. Verifique la contraseña o la configuración 'legacy' de OpenSSL.");
        }

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
}
