<?php

namespace PlatinumPlace\DgiiXmlSigner\Tests;

use PHPUnit\Framework\TestCase;
use PlatinumPlace\DgiiXmlSigner\SignManager;

class SignManagerTest extends TestCase
{
    public function test_sign_manager_can_be_instantiated(): void
    {
        $signManager = new SignManager();

        $this->assertInstanceOf(SignManager::class, $signManager);
    }

    public function test_sign_throws_exception_with_invalid_certificate(): void
    {
        $this->expectException(\RuntimeException::class);

        $signManager = new SignManager();
        $signManager->sing('invalid-cert', 'password', '<xml/>');
    }

    public function test_verify_p12_returns_false_with_invalid_certificate(): void
    {
        $signManager = new SignManager();

        $this->assertFalse($signManager->verifyP12('invalid-cert', 'password'));
    }
}
