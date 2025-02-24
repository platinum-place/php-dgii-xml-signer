<?php

namespace Signer\Services;

use Exception;
use RuntimeException;

class StorageService
{
    /**
     * @throws Exception
     */
    public function getFileContent(string $filePath): string
    {
        $filePath = __DIR__ . "/../storage/{$filePath}";
        if (!file_exists($filePath)) {
            throw new Exception("El archivo no existe: {$filePath}");
        }
        return file_get_contents($filePath) ?: throw new Exception("Error al leer: {$filePath}");
    }

}