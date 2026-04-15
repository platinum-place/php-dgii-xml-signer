<?php

namespace PlatinumPlace\DgiiXmlSigner;

use DOMDocument;
use DOMElement;
use DOMXPath;
use OpenSSLCertificate;
use Selective\XmlDSig\CryptoSignerInterface;
use Selective\XmlDSig\Exception\XmlSignerException;
use Selective\XmlDSig\X509Reader;
use Selective\XmlDSig\XmlReader;
use UnexpectedValueException;

/**
 * Personalización del firmador XMLDSIG para cumplir con los requerimientos específicos de la DGII.
 *
 * Implementa las variaciones en la normalización C14N (Canonicalización) 
 * requeridas para el sistema de facturación electrónica de la República Dominicana,
 * asegurando la compatibilidad con el validador oficial de la DGII.
 * 
 * @package PlatinumPlace\DgiiXmlSigner
 */
final class XmlSigner
{
    /** @var string URI de referencia para la firma (vacío por defecto para referenciar todo el documento) */
    private string $referenceUri = '';

    /** @var XmlReader Lector de XML de la librería base selective/xmldsig */
    private XmlReader $xmlReader;

    /** @var CryptoSignerInterface Instancia encargada de las operaciones criptográficas */
    private CryptoSignerInterface $cryptoSigner;

    /**
     * Inicializa el firmador con el motor criptográfico configurado.
     * 
     * @param CryptoSignerInterface $cryptoSigner Instancia que contiene las claves y algoritmos de firma
     */
    public function __construct(CryptoSignerInterface $cryptoSigner)
    {
        $this->xmlReader = new XmlReader();
        $this->cryptoSigner = $cryptoSigner;
    }

    /**
     * Firma el contenido XML en string y lo devuelve como string firmado.
     *
     * @param string $data El contenido XML original que se desea procesar
     * @return string El XML firmado (con el bloque <Signature> inyectado)
     * @throws XmlSignerException Si el XML proporcionado es inválido o el proceso de firma falla
     */
    public function signXml(string $data): string
    {
        $xml = new DOMDocument();

        // Configuración requerida por la DGII para evitar alteraciones en el digest debido a indentación
        $xml->preserveWhiteSpace = false;
        $xml->formatOutput = false;

        if (!$xml->loadXML($data)) {
            throw new XmlSignerException('No se pudo cargar el XML proporcionado.');
        }

        if (!$xml->documentElement) {
            throw new XmlSignerException('El documento XML no tiene un elemento raíz definido.');
        }

        return $this->signDocument($xml);
    }

    /**
     * Firma un objeto DOMDocument de forma directa.
     *
     * @param DOMDocument $document Documento DOM cargado
     * @param DOMElement|null $element Elemento específico a firmar (si es null, firma la raíz)
     * @return string El XML resultante en formato string
     * @throws XmlSignerException Si el elemento raíz es nulo o hay fallos en la canonicalización
     */
    public function signDocument(DOMDocument $document, ?DOMElement $element = null): string
    {
        $element = $element ?? $document->documentElement;

        if ($element === null) {
            throw new XmlSignerException('Elemento XML no válido para el proceso de firma.');
        }

        /** 
         * Cambio técnico específico para DGII: 
         * Se realiza la normalización exclusiva (C14N) sin parámetros explícitos 
         * para garantizar que los namespaces se traten según el requerimiento dominicano.
         */
        $canonicalData = $element->C14N();

        $digestValue = $this->cryptoSigner->computeDigest($canonicalData);
        $digestValueEncoded = base64_encode($digestValue);

        $this->appendSignature($document, $digestValueEncoded);

        $result = $document->saveXML();

        if ($result === false) {
            throw new XmlSignerException('Error al guardar el XML firmado.');
        }

        return $result;
    }

    /**
     * Inserta la estructura <Signature> requerida por el estándar XMLDSig.
     *
     * @param DOMDocument $xml Documento donde se inyectará la firma
     * @param string $digestValue Valor hash (digest) calculado para el elemento referenciado
     * @throws UnexpectedValueException Si el documento no tiene un elemento raíz válido
     */
    private function appendSignature(DOMDocument $xml, string $digestValue): void
    {
        if (!$xml->documentElement) {
            throw new UnexpectedValueException('Elemento raíz no definido.');
        }

        $signatureElement = $xml->createElement('Signature');
        $signatureElement->setAttribute('xmlns', 'http://www.w3.org/2000/09/xmldsig#');
        $xml->documentElement->appendChild($signatureElement);

        $signedInfoElement = $xml->createElement('SignedInfo');
        $signatureElement->appendChild($signedInfoElement);

        $canonicalizationMethodElement = $xml->createElement('CanonicalizationMethod');
        $canonicalizationMethodElement->setAttribute('Algorithm', 'http://www.w3.org/TR/2001/REC-xml-c14n-20010315');
        $signedInfoElement->appendChild($canonicalizationMethodElement);

        $signatureMethodElement = $xml->createElement('SignatureMethod');
        $signatureMethodElement->setAttribute(
            'Algorithm',
            $this->cryptoSigner->getAlgorithm()->getSignatureAlgorithmUrl()
        );
        $signedInfoElement->appendChild($signatureMethodElement);

        $referenceElement = $xml->createElement('Reference');
        $referenceElement->setAttribute('URI', $this->referenceUri);
        $signedInfoElement->appendChild($referenceElement);

        $transformsElement = $xml->createElement('Transforms');
        $referenceElement->appendChild($transformsElement);

        $transformElement = $xml->createElement('Transform');
        $transformElement->setAttribute('Algorithm', 'http://www.w3.org/2000/09/xmldsig#enveloped-signature');
        $transformsElement->appendChild($transformElement);

        $digestMethodElement = $xml->createElement('DigestMethod');
        $digestMethodElement->setAttribute('Algorithm', $this->cryptoSigner->getAlgorithm()->getDigestAlgorithmUrl());
        $referenceElement->appendChild($digestMethodElement);

        $digestValueElement = $xml->createElement('DigestValue', $digestValue);
        $referenceElement->appendChild($digestValueElement);

        $signatureValueElement = $xml->createElement('SignatureValue', '');
        $signatureElement->appendChild($signatureValueElement);

        $keyInfoElement = $xml->createElement('KeyInfo');
        $signatureElement->appendChild($keyInfoElement);

        // Los certificados se añaden al KeyInfo si están configurados en el almacén de claves
        $certificates = $this->cryptoSigner->getPrivateKeyStore()->getCertificates();
        if ($certificates) {
            $this->appendX509Certificates($xml, $keyInfoElement, $certificates);
        }

        /** 
         * Segundo cambio técnico crítico para DGII: 
         * Normalización C14N() sin parámetros en el bloque SignedInfo 
         * antes de calcular el SignatureValue.
         */
        $c14nSignedInfo = $signedInfoElement->C14N();

        $signatureValue = $this->cryptoSigner->computeSignature($c14nSignedInfo);

        $xpath = new DOMXPath($xml);
        $signatureValueElement = $this->xmlReader->queryDomNode($xpath, '//SignatureValue', $signatureElement);
        $signatureValueElement->nodeValue = base64_encode($signatureValue);
    }

    /**
     * Crea y añade el elemento X509Data con los certificados en formato base64.
     *
     * @param DOMDocument $xml Documento XML
     * @param DOMElement $keyInfoElement Nodo <KeyInfo> donde se insertará la información
     * @param OpenSSLCertificate[] $certificates Lista de certificados a incrustar
     */
    private function appendX509Certificates(DOMDocument $xml, DOMElement $keyInfoElement, array $certificates): void
    {
        $x509DataElement = $xml->createElement('X509Data');
        $keyInfoElement->appendChild($x509DataElement);

        $x509Reader = new X509Reader();
        foreach ($certificates as $certificateId) {
            $certificate = $x509Reader->toRawBase64($certificateId);

            $x509CertificateElement = $xml->createElement('X509Certificate', $certificate);
            $x509DataElement->appendChild($x509CertificateElement);
        }
    }

    /**
     * Establece el URI de referencia para el bloque <Reference>.
     * 
     * Por defecto se utiliza un string vacío para referenciar a todo el documento.
     * 
     * @param string $referenceUri El identificador de referencia (ej. "#id_del_elemento")
     * @return void
     */
    public function setReferenceUri(string $referenceUri): void
    {
        $this->referenceUri = $referenceUri;
    }
}

