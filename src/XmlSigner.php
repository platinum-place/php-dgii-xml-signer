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
 * Customization of the XMLDSIG signer to meet specific DGII requirements.
 *
 * Implements variations in C14N normalization (Canonicalization)
 * required for the electronic invoicing system of the Dominican Republic,
 * ensuring compatibility with the official DGII validator.
 */
final class XmlSigner
{
    /** @var string Reference URI for the signature (empty by default to reference the entire document) */
    private string $referenceUri = '';

    /** @var XmlReader XML reader from the base selective/xmldsig library */
    private XmlReader $xmlReader;

    /** @var CryptoSignerInterface Instance in charge of cryptographic operations */
    private CryptoSignerInterface $cryptoSigner;

    /**
     * Initialize the signer with the configured cryptographic engine.
     *
     * @param CryptoSignerInterface $cryptoSigner Instance containing signing keys and algorithms.
     */
    public function __construct(CryptoSignerInterface $cryptoSigner)
    {
        $this->xmlReader = new XmlReader();
        $this->cryptoSigner = $cryptoSigner;
    }

    /**
     * Sign XML content as string and return the signed XML string.
     *
     * @param string $data The original XML content to process.
     * @return string The signed XML (with the <Signature> block injected).
     * @throws XmlSignerException If the provided XML is invalid or the signing process fails.
     */
    public function signXml(string $data): string
    {
        $xml = new DOMDocument();

        // Required DGII configuration to avoid digest alterations due to indentation
        $xml->preserveWhiteSpace = false;
        $xml->formatOutput = false;

        if (!$xml->loadXML($data)) {
            throw new XmlSignerException('Unable to load provided XML.');
        }

        if (!$xml->documentElement) {
            throw new XmlSignerException('The XML document has no root element defined.');
        }

        return $this->signDocument($xml);
    }

    /**
     * Sign a DOMDocument object directly.
     *
     * @param DOMDocument $document Loaded DOM document.
     * @param DOMElement|null $element Specific element to sign (if null, signs the root).
     * @return string The resulting XML in string format.
     * @throws XmlSignerException If the root element is null or canonicalization fails.
     */
    public function signDocument(DOMDocument $document, ?DOMElement $element = null): string
    {
        $element = $element ?? $document->documentElement;

        if ($element === null) {
            throw new XmlSignerException('Invalid XML element for the signing process.');
        }

        /**
         * Technical change specific for DGII:
         * Exclusive normalization (C14N) is performed without explicit parameters
         * to ensure namespaces are handled according to Dominican requirements.
         */
        $canonicalData = $element->C14N();

        $digestValue = $this->cryptoSigner->computeDigest($canonicalData);
        $digestValueEncoded = base64_encode($digestValue);

        $this->appendSignature($document, $digestValueEncoded);

        $result = $document->saveXML();

        if ($result === false) {
            throw new XmlSignerException('Error saving the signed XML.');
        }

        return $result;
    }

    /**
     * Inserts the <Signature> structure required by the XMLDSig standard.
     *
     * @param DOMDocument $xml Document where the signature will be injected.
     * @param string $digestValue Hash value (digest) calculated for the referenced element.
     * @throws UnexpectedValueException If the document has no valid root element.
     */
    private function appendSignature(DOMDocument $xml, string $digestValue): void
    {
        if (!$xml->documentElement) {
            throw new UnexpectedValueException('Root element not defined.');
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

        // Certificates are added to KeyInfo if configured in the key store
        $certificates = $this->cryptoSigner->getPrivateKeyStore()->getCertificates();
        if ($certificates) {
            $this->appendX509Certificates($xml, $keyInfoElement, $certificates);
        }

        /**
         * Critical technical change for DGII:
         * C14N() normalization without parameters in the SignedInfo block
         * before calculating the SignatureValue.
         */
        $c14nSignedInfo = $signedInfoElement->C14N();

        $signatureValue = $this->cryptoSigner->computeSignature($c14nSignedInfo);

        $xpath = new DOMXPath($xml);
        $signatureValueElement = $this->xmlReader->queryDomNode($xpath, '//SignatureValue', $signatureElement);
        $signatureValueElement->nodeValue = base64_encode($signatureValue);
    }

    /**
     * Creates and adds the X509Data element with certificates in base64 format.
     *
     * @param DOMDocument $xml XML Document.
     * @param DOMElement $keyInfoElement <KeyInfo> node where the info will be inserted.
     * @param OpenSSLCertificate[] $certificates List of certificates to embed.
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
     * Set the reference URI for the <Reference> block.
     *
     * By default, an empty string is used to reference the entire document.
     *
     * @param string $referenceUri The reference identifier (e.g., "#element_id").
     * @return void
     */
    public function setReferenceUri(string $referenceUri): void
    {
        $this->referenceUri = $referenceUri;
    }
}
