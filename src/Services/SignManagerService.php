<?php

namespace Signer\Services;

use Exception;
use Selective\XmlDSig\Algorithm;
use Selective\XmlDSig\CryptoSigner;
use Selective\XmlDSig\PrivateKeyStore;
use Signer\Utils\Selective\XmlSigner;

class SignManagerService
{
    /**
     * @throws Exception
     */
    public function sign(string $cert_store, string $password, string $xml): string
    {
        if (!openssl_pkcs12_read($cert_store, $certs, $password)) {
            throw new Exception(openssl_error_string());
        }
        $pem_file_contents = $certs['cert'] . $certs['pkey'];
        $privateKeyStore = new PrivateKeyStore;
        $privateKeyStore->loadFromPem($pem_file_contents, $password);

        $privateKeyStore->addCertificatesFromX509Pem($pem_file_contents);
        $algorithm = new Algorithm(Algorithm::METHOD_SHA256);
        $cryptoSigner = new CryptoSigner($privateKeyStore, $algorithm);
        $xmlSigner = new XmlSigner($cryptoSigner);
        $xmlSigner->setReferenceUri('');

        return $xmlSigner->signXml($xml);
    }
}