<?php

namespace App\Services\SignManager;

use App\Helpers\Selective\XmlSignerHelper;
use Exception;
use Selective\XmlDSig\Algorithm;
use Selective\XmlDSig\CryptoSigner;
use Selective\XmlDSig\PrivateKeyStore;

class SignManagerService implements SignManagerInterface
{
    /**
     * @throws Exception
     */
    public function sign(string $cert_store, string $password, string $xml): string|Exception
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
        $xmlSigner = new XmlSignerHelper($cryptoSigner);
        $xmlSigner->setReferenceUri('');

        return $xmlSigner->signXml($xml);
    }
}
