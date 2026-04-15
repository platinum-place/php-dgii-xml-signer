<?php

namespace PlatinumPlace\DgiiXmlSigner\Tests;

use PHPUnit\Framework\TestCase;
use PlatinumPlace\DgiiXmlSigner\SignManager;
use PlatinumPlace\DgiiXmlSigner\Exception\DgiiXmlSignerException;

/**
 * Pruebas unitarias y funcionales para la clase SignManager.
 * 
 * Valida la correcta instanciación, la existencia de alias de métodos y el
 * proceso completo de firmado digital de documentos XML para la DGII.
 * 
 * @package PlatinumPlace\DgiiXmlSigner\Tests
 */
class SignManagerTest extends TestCase
{
    /** @var string Directorio donde se almacenan los archivos de prueba (fixtures) */
    private string $fixturesDir = __DIR__ . '/Fixtures';

    /**
     * Verifica que el SignManager se pueda instanciar correctamente.
     * 
     * Asegura que no existan errores de sintaxis o problemas en la carga de dependencias.
     * 
     * @return void
     */
    public function test_can_instantiate_sign_manager()
    {
        $manager = new SignManager();
        $this->assertInstanceOf(SignManager::class, $manager);
    }

    /**
     * Verifica la disponibilidad de los métodos 'sign' y 'sing'.
     * 
     * El método 'sign' es el estándar moderno, mientras que 'sing' mantiene
     * la compatibilidad con la documentación técnica oficial de la DGII.
     * 
     * @return void
     */
    public function test_has_sign_alias_for_sing()
    {
        $manager = new SignManager();
        $this->assertTrue(method_exists($manager, 'sign'), 'El alias sign() debe estar disponible para cumplimiento de estándares.');
        $this->assertTrue(method_exists($manager, 'sing'), 'El método original sing() debe mantenerse para seguir la documentación de la DGII.');
    }

    /**
     * Prueba funcional del proceso de firmado digital.
     * 
     * Este test requiere un certificado de prueba real (.p12) en la carpeta de fixtures.
     * Si no se encuentra el archivo 'test_cert.p12', la prueba se marcará como omitida.
     * 
     * @return void
     */
    public function test_functional_signature_process()
    {
        // Ruta genérica para un certificado de prueba configurado por el desarrollador
        $certPath = $this->fixturesDir . '/test_cert.p12';
        $xmlPath = $this->fixturesDir . '/documento_prueba.xml';

        // Si faltan los archivos necesarios, saltamos la prueba sin fallar el build
        if (!file_exists($certPath) || !file_exists($xmlPath)) {
            $this->markTestSkipped('Se requiere un certificado "test_cert.p12" en tests/Fixtures para ejecutar el test funcional.');
        }

        $certContent = file_get_contents($certPath);
        $xmlContent = file_get_contents($xmlPath);
        
        // Contraseña de prueba (debe coincidir con la del certificado test_cert.p12)
        $password = 'password_de_prueba'; 

        $manager = new SignManager();
        
        try {
            $signedXml = $manager->sign($certContent, $password, $xmlContent);
            
            // Verificaciones de estructura básica del XMLDSig resultante
            $this->assertStringContainsString('<Signature', $signedXml, 'El XML generado debe contener la etiqueta <Signature>');
            $this->assertStringContainsString('http://www.w3.org/2000/09/xmldsig#', $signedXml, 'El namespace de la firma debe ser el estándar oficial.');
        } catch (DgiiXmlSignerException $e) {
            $this->fail('Error inesperado en el proceso de firmado funcional: ' . $e->getMessage());
        }
    }

    /**
     * Valida la gestión de errores ante certificados inválidos.
     * 
     * Asegura que el sistema lance una excepción DgiiXmlSignerException
     * controlada en lugar de errores fatales de la extensión OpenSSL.
     * 
     * @return void
     */
    public function test_throws_exception_on_invalid_certificate()
    {
        $this->expectException(DgiiXmlSignerException::class);
        
        $manager = new SignManager();
        // Simulación de un intento de firma con datos corruptos
        $manager->sing('invalid_cert_content', 'wrong_password', '<xml></xml>');
    }
}
