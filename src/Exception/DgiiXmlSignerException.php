<?php

namespace PlatinumPlace\DgiiXmlSigner\Exception;

use RuntimeException;

/**
 * Base exception for errors during the DGII document signing process.
 *
 * This exception is thrown when failures occur during P12 certificate reading,
 * OpenSSL configuration errors, or issues with the structure of the original XML.
 */
class DgiiXmlSignerException extends RuntimeException
{
}
