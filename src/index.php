<?php

require __DIR__ . '/../vendor/autoload.php';

\Signer\Services\EnvironmentService::loadEnvironment();

try {
    $storageService = new \Signer\Services\StorageService();

    $certContent = $storageService->getFileContent('certs/' . getenv('CERT_NAME'));
    $certPassword = getenv('CERT_PASSWORD');
    $xmlContent = $storageService->getFileContent('xml/' . getenv('XML_NAME'));

    $signedXML = (new \Signer\Services\SignManagerService())->sign($certContent, $certPassword, $xmlContent);

    echo $signedXML . PHP_EOL;
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
