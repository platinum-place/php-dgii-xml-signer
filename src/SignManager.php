<?php

namespace PlatinumPlace\DgiiXmlSigner;

use PlatinumPlace\DgiiXmlSigner\Exception\DgiiXmlSignerException;
use Selective\XmlDSig\Algorithm;
use Selective\XmlDSig\CryptoSigner;
use Selective\XmlDSig\PrivateKeyStore;

/**
 * Manager to handle XML signing according to DGII requirements.
 *
 * This class acts as the main entry point for digital signing of
 * electronic fiscal receipts (e-CF) following the XMLDSig standard
 * and Dominican Republic technical specifications.
 */
final class SignManager
{
    /**
     * Alias for sing() method for clarity and PSR standards compliance.
     *
     * @param string $cert_store Binary content of the certificate file (.p12)
     * @param string $password Certificate password
     * @param string $xml XML content to be signed
     * @return string The resulting XML with the embedded digital signature
     * @throws DgiiXmlSignerException If an error occurs during the signing process
     */
    public function sign(string $cert_store, string $password, string $xml): string
    {
        return $this->sing($cert_store, $password, $xml);
    }

    /**
     * Sign the XML following the nomenclature suggested by DGII documentation.
     *
     * @param string $cert_store Binary content of the certificate file (.p12)
     * @param string $password Password to access the certificate private key
     * @param string $xml XML content of the file to process
     * @return string Digitally signed XML
     * @throws DgiiXmlSignerException If certificate is invalid, password is incorrect
     *                                or there is a technical error in normalization/signing
     */
    public function sing(string $cert_store, string $password, string $xml): string
    {
        if (!openssl_pkcs12_read($cert_store, $certs, $password)) {
            throw new DgiiXmlSignerException("Error: Unable to read certificate content. Verify password or OpenSSL 'legacy' configuration.");
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
