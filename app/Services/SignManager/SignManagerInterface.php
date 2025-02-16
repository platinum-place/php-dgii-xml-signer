<?php

namespace App\Services\SignManager;

use Exception;

interface SignManagerInterface
{
    public function sign(string $cert_store, string $password, string $xml): string|Exception;
}
