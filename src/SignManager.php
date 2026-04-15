<?php

namespace PlatinumPlace\DgiiXmlSigner;

use PlatinumPlace\DgiiXmlSigner\Exception\DgiiXmlSignerException;
use Selective\XmlDSig\Algorithm;
use Selective\XmlDSig\CryptoSigner;
use Selective\XmlDSig\PrivateKeyStore;

/**
 * Manager para gestionar el firmado de XML conforme a los requerimientos de la DGII.
 * 
 * Esta clase actúa como el punto de entrada principal para realizar el firmado digital
 * de comprobantes fiscales electrónicos (e-CF) siguiendo el estándar XMLDSig y las
 * especificaciones técnicas de la República Dominicana.
 * 
 * @package PlatinumPlace\DgiiXmlSigner
 */
final class SignManager
{
    /**
     * Alias del método sing() para mayor claridad y cumplimiento de estándares PSR.
     * 
     * @param string $cert_store Contenido binario del archivo de certificado (.p12)
     * @param string $password Contraseña del certificado para su lectura
     * @param string $xml Contenido del XML que se desea firmar
     * @return string El XML resultante con la firma digital incrustada
     * @throws DgiiXmlSignerException Si ocurre un error durante el proceso de firma
     */
    public function sign(string $cert_store, string $password, string $xml): string
    {
        return $this->sing($cert_store, $password, $xml);
    }

    /**
     * Firma el XML siguiendo la nomenclatura sugerida por la documentación de la DGII.
     *
     * @param string $cert_store Contenido binario del archivo de certificado (.p12)
     * @param string $password Contraseña para acceder a la clave privada del certificado
     * @param string $xml Contenido del archivo XML a procesar
     * @return string XML firmado digitalmente
     * @throws DgiiXmlSignerException Si el certificado no es válido, la contraseña es incorrecta 
     *                                o hay un error técnico en el proceso de normalización/firma
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
