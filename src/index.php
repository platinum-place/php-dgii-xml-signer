<?php

use Signer\SignManager;

require __DIR__ . '/../vendor/autoload.php';

try {
    $certContent = '';
    $certPassword = '';
    $xmlContent = '';

    $signedXML = (new SignManager)->sing($certContent, $certPassword, $xmlContent);

    echo $signedXML . PHP_EOL;
} catch (Exception $e) {
    echo $e->getMessage() . PHP_EOL;
}
