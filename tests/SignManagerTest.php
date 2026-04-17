<?php

namespace PlatinumPlace\DgiiXmlSigner\Tests;

use PHPUnit\Framework\TestCase;
use PlatinumPlace\DgiiXmlSigner\SignManager;
use PlatinumPlace\DgiiXmlSigner\Exception\DgiiXmlSignerException;

/**
 * Unit and functional tests for the SignManager class.
 *
 * Validates proper instantiation, method alias existence, and the complete
 * digital signing process for DGII XML documents.
 */
class SignManagerTest extends TestCase
{
    /** @var string Directory where test fixtures are stored */
    private string $fixturesDir = __DIR__ . '/Fixtures';

    /**
     * Verify that SignManager can be instantiated correctly.
     *
     * Ensures there are no syntax errors or dependency loading issues.
     *
     * @return void
     */
    public function test_can_instantiate_sign_manager()
    {
        $manager = new SignManager();
        $this->assertInstanceOf(SignManager::class, $manager);
    }

    /**
     * Verify the availability of both 'sign' and 'sing' methods.
     *
     * The 'sign' method is the modern standard, while 'sing' maintains
     * compatibility with official DGII technical documentation.
     *
     * @return void
     */
    public function test_has_sign_alias_for_sing()
    {
        $manager = new SignManager();
        $this->assertTrue(method_exists($manager, 'sign'), 'The sign() alias should be available for standards compliance.');
        $this->assertTrue(method_exists($manager, 'sing'), 'The original sing() method must be maintained to follow DGII documentation.');
    }

    /**
     * Functional test for the digital signing process.
     *
     * This test requires a real test certificate (.p12) in the fixtures folder.
     * If "test_cert.p12" is not found, the test will be marked as skipped.
     *
     * @return void
     */
    public function test_functional_signature_process()
    {
        // Generic path for a test certificate configured by the developer
        $certPath = $this->fixturesDir . '/test_cert.p12';
        $xmlPath = $this->fixturesDir . '/documento_prueba.xml';

        // Skip if required files are missing to avoid build failures
        if (!file_exists($certPath) || !file_exists($xmlPath)) {
            $this->markTestSkipped('A "test_cert.p12" certificate is required in tests/Fixtures to run the functional test.');
        }

        $certContent = file_get_contents($certPath);
        $xmlContent = file_get_contents($xmlPath);

        // Test password (must match the one from test_cert.p12)
        $password = 'test_password';

        $manager = new SignManager();

        try {
            $signedXml = $manager->sign($certContent, $password, $xmlContent);

            // Verify basic structure of the resulting XMLDSig
            $this->assertStringContainsString('<Signature', $signedXml, 'The generated XML must contain the <Signature> tag.');
            $this->assertStringContainsString('http://www.w3.org/2000/09/xmldsig#', $signedXml, 'The signature namespace must be the official standard.');
        } catch (DgiiXmlSignerException $e) {
            $this->fail('Unexpected error in functional signing process: ' . $e->getMessage());
        }
    }

    /**
     * Validate error handling for invalid certificates.
     *
     * Ensures the system throws a controlled DgiiXmlSignerException
     * instead of fatal errors from the OpenSSL extension.
     *
     * @return void
     */
    public function test_throws_exception_on_invalid_certificate()
    {
        $this->expectException(DgiiXmlSignerException::class);

        $manager = new SignManager();
        // Simulate a signing attempt with corrupt data
        $manager->sing('invalid_cert_content', 'wrong_password', '<xml></xml>');
    }
}
