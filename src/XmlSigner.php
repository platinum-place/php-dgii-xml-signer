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
 * requeridas para el sistema de facturación electrónica de la República Dominicana.
 */
final class XmlSigner
{
    private string $referenceUri = '';
    private XmlReader $xmlReader;
    private CryptoSignerInterface $cryptoSigner;

    public function __construct(CryptoSignerInterface $cryptoSigner)
    {
        $this->xmlReader = new XmlReader();
        $this->cryptoSigner = $cryptoSigner;
    }

    /**
     * Firma el contenido XML y lo devuelve como string.
     *
     * @param string $data El contenido XML original
     * @return string El XML firmado
     * @throws XmlSignerException Si el XML es inválido o el proceso falla
     */
    public function signXml(string $data): string
    {
        $xml = new DOMDocument();

        // Configuración requerida por DGII para evitar espacios innecesarios
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
     * Firma un objeto DOMDocument.
     *
     * @param DOMDocument $document
     * @param DOMElement|null $element Elemento específico a firmar (por defecto la raíz)
     * @return string XML resultante
     * @throws XmlSignerException
     */
    public function signDocument(DOMDocument $document, ?DOMElement $element = null): string
    {
        $element = $element ?? $document->documentElement;

        if ($element === null) {
            throw new XmlSignerException('Elemento XML no válido para el proceso de firma.');
        }

        // Cambio crítico para DGII: Normalización exclusiva sin parámetros (false, false por defecto)
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
     * Inserta la estructura <Signature> en el XML.
     *
     * @throws UnexpectedValueException
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

        // Los certificados se añaden al KeyInfo si están presentes
        $certificates = $this->cryptoSigner->getPrivateKeyStore()->getCertificates();
        if ($certificates) {
            $this->appendX509Certificates($xml, $keyInfoElement, $certificates);
        }

        // Segundo cambio crítico para DGII: C14N() sin parámetros en SignedInfo
        $c14nSignedInfo = $signedInfoElement->C14N();

        $signatureValue = $this->cryptoSigner->computeSignature($c14nSignedInfo);

        $xpath = new DOMXPath($xml);
        $signatureValueElement = $this->xmlReader->queryDomNode($xpath, '//SignatureValue', $signatureElement);
        $signatureValueElement->nodeValue = base64_encode($signatureValue);
    }

    /**
     * Crea y añade el elemento X509Data con los certificados en base64.
     *
     * @param OpenSSLCertificate[] $certificates
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

    public function setReferenceUri(string $referenceUri): void
    {
        $this->referenceUri = $referenceUri;
    }
}
