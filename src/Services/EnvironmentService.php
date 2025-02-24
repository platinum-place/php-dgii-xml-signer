<?php

namespace Signer\Services;

class EnvironmentService
{
    public static function loadEnvironment(): void
    {
        $envFile = __DIR__ . '/../../.env';

        if (file_exists($envFile)) {
            $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

            foreach ($lines as $line) {
                if (str_starts_with(trim($line), '#')) {
                    continue;
                }

                list($name, $value) = explode('=', $line, 2);

                $value = trim($value, "'\"");

                putenv("$name=$value");
            }
        }
    }
}
