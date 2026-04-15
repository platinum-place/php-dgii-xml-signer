<?php

namespace PlatinumPlace\DgiiXmlSigner\Exception;

use RuntimeException;

/**
 * Excepción base para errores durante el proceso de firmado de documentos para la DGII.
 * 
 * Se lanza cuando ocurren fallos en la lectura del certificado P12, errores de
 * configuración de OpenSSL, o problemas en la estructura del XML original.
 * 
 * @package PlatinumPlace\DgiiXmlSigner\Exception
 */
class DgiiXmlSignerException extends RuntimeException
{
}
