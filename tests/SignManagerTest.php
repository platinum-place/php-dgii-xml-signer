<?php

namespace PlatinumPlace\DgiiXmlSigner\Tests;

use PHPUnit\Framework\TestCase;
use PlatinumPlace\DgiiXmlSigner\SignManager;
use PlatinumPlace\DgiiXmlSigner\Exception\DgiiXmlSignerException;

/**
 * Clase de pruebas para validar el funcionamiento del SignManager.
 */
class SignManagerTest extends TestCase
{
    /** @var string Directorio donde se almacenan los archivos de prueba */
    private string $fixturesDir = __DIR__ . '/Fixtures';

    /**
     * Prueba que el SignManager se puede instanciar correctamente.
     * Es la prueba más básica para asegurar que no hay errores de sintaxis o carga de clases.
     */
    public function test_can_instantiate_sign_manager()
    {
        $manager = new SignManager();
        $this->assertInstanceOf(SignManager::class, $manager);
    }

    /**
     * Verifica que existan tanto el método 'sign' (alias moderno) como el método 'sing' (DGII).
     * Esto asegura la compatibilidad con desarrolladores actuales y con la documentación oficial.
     */
    public function test_has_sign_alias_for_sing()
    {
        $manager = new SignManager();
        $this->assertTrue(method_exists($manager, 'sign'), 'El alias sign() debe existir para cumplimiento de estándares.');
        $this->assertTrue(method_exists($manager, 'sing'), 'El método original sing() debe mantenerse para seguir la doc de la DGII.');
    }

    /**
     * Test funcional que intenta realizar un firmado real si los archivos están presentes.
     * 
     * NOTA: Este test se omitirá automáticamente si no se encuentra un certificado
     * en tests/Fixtures/test_cert.p12 (nombre genérico sugerido).
     */
    public function test_functional_signature_process()
    {
        // Ruta genérica para que el desarrollador ponga su certificado de prueba
        $certPath = $this->fixturesDir . '/test_cert.p12';
        $xmlPath = $this->fixturesDir . '/documento_prueba.xml';

        // Si no existen los archivos, saltamos la prueba en lugar de fallar
        if (!file_exists($certPath) || !file_exists($xmlPath)) {
            $this->markTestSkipped('No se encontró un certificado de prueba para el test funcional.');
        }

        $certContent = file_get_contents($certPath);
        $xmlContent = file_get_contents($xmlPath);
        
        // El desarrollador debe configurar la clave de su certificado de prueba aquí
        $password = 'password_de_prueba'; 

        $manager = new SignManager();
        
        try {
            $signedXml = $manager->sign($certContent, $password, $xmlContent);
            
            // Verificamos que el XML resultante contenga la firma digital
            $this->assertStringContainsString('<Signature', $signedXml, 'El XML generado debe contener la etiqueta <Signature>');
            $this->assertStringContainsString('http://www.w3.org/2000/09/xmldsig#', $signedXml, 'El namespace de la firma debe ser correcto.');
        } catch (DgiiXmlSignerException $e) {
            // Si falla por contraseña incorrecta u OpenSSL Legacy, lo capturamos aquí para informar
            $this->fail('Fallo en el firmado funcional: ' . $e->getMessage());
        }
    }

    /**
     * Valida que el sistema lance una excepción personalizada cuando se intenta
     * usar un certificado inválido o corrupto, en lugar de un error fatal de PHP.
     */
    public function test_throws_exception_on_invalid_certificate()
    {
        $this->expectException(DgiiXmlSignerException::class);
        
        $manager = new SignManager();
        // Intentamos firmar con un string que claramente no es un certificado p12 válido
        $manager->sing('contenido_invalido_que_no_es_p12', 'password_cualquiera', '<xml></xml>');
    }
}
