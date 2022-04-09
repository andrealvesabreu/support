<?php
declare(strict_types = 1);
namespace Inspire\Support\Xml;

use Inspire\Support\Message\Serialize\XmlMessage;

/**
 * Description of Xml
 *
 * @author aalves
 */
class Xml extends XmlMessage
{

    /**
     *
     * @param mixed $data
     * @throws \Exception
     */
    public function __construct($data, bool $clearNamespaces = false)
    {
        // Input XML
        if (! is_string($data) || empty($data)) {
            throw new \Exception("'data' must be a non-empty string.");
        }
        /**
         * Load XML if URL is provided as XML
         */
        if (preg_match('~^https?://[^\s]+$~i', $data) || is_readable($data)) {
            $xmlData = trim(file_get_contents($data));
        } else {
            $xmlData = trim($data);
        }
        if ($clearNamespaces) {
            // Let's drop namespace definitions
            if (stripos($xmlData, 'xmlns=') !== false) {
                $xmlData = preg_replace('~[\s]+xmlns=[\'"].+?[\'"]~i', '', $xmlData);
            }
            // Change namespaced attributes
            $matches = [];
            if (preg_match_all('~xmlns:([a-z0-9]+)=~i', $xmlData, $matches)) {
                $namespaces = array_unique($matches[1]);
                foreach ($namespaces as $namespace) {
                    $escaped_namespace = preg_quote($namespace, '~');
                    $xmlData = preg_replace('~[\s]xmlns:' . $escaped_namespace . '=[\'].+?[\']~i', null, $xmlData);
                    $xmlData = preg_replace('~[\s]xmlns:' . $escaped_namespace . '=["].+?["]~i', null, $xmlData);
                    $xmlData = preg_replace('~([\'"\s])' . $escaped_namespace . ':~i', '$1' . $namespace . '_', $xmlData);
                }
            }
            // Let's change <namespace:tag to <namespace_tag ns="namespace"
            $regexfrom = sprintf('~<([a-z0-9]+):%s~is', null);
            // $regexto = strlen($nsattr) ? '<$1_$2 ' . $nsattr . '="$1"' : '<$1_';
            $xmlData = preg_replace($regexfrom, '', $xmlData);
            // Let's change </namespace:tag> to </namespace_tag>
            $xmlData = preg_replace('~</([a-z0-9]+):~is', '</$1_', $xmlData);
        }
        libxml_use_internal_errors(true);
        libxml_clear_errors();
        $this->xml = simplexml_load_string($xmlData, '\SimpleXMLElement', LIBXML_COMPACT | LIBXML_NOBLANKS | LIBXML_NOCDATA);
        if (! empty(libxml_get_errors())) {
            throw new \Exception("You must provide a valid XML.");
        }
        $this->stringXml = $xmlData;
    }

    /**
     * Get string XML
     *
     * @return string
     */
    public function getXml(): string
    {
        return $this->stringXml;
    }

    /**
     * Remove XML declaration from every index of array or an input string
     *
     * @param string|array $xml
     * @return string|array
     */
    public static function clearXmlDeclaration($xml)
    {
        if (is_array($xml)) {
            return array_map(function ($v) {
                return trim(preg_replace("/<\?xml.+?\?>/", "", $v));
            }, $xml);
        }
        return trim(preg_replace("/<\?xml.+?\?>/", "", $xml));
    }

    /**
     * Convert array to XML
     *
     * @param array $data
     * @param string $root
     * @param bool $self
     * @return \Inspire\Support\Xml\Xml|string
     */
    public static function arrayToXml(array $data, ?string $root = null, bool $self = false)
    {
        if (($root === null || empty($root)) && count($data) == 1) {
            $root = array_keys($data)[0];
            $data = $data[$root];
        }
        $xml = Array2XML::createXML($root, $data)->saveXML();
        if ($self) {
            return new Xml($xml);
        }
        return $xml;
    }

    /**
     * Convert XML to array
     *
     * @param string $xml
     * @return array
     */
    public static function xmlToArray(string $xml): array
    {
        return XML2Array::createArray($xml);
    }

    /**
     * Get DOMnode from XML
     *
     * @param string $xpath
     * @param int $index
     * @return array|\DOMNode|null
     */
    public function xpathXml(string $xpath, int $index = null)
    {
        $out = [];
        if ($index !== null) {
            $out = null;
        }
        $result = $this->xml->xpath("/{$xpath}");
        if ($result && ! empty($result)) {
            if ($index !== null) {
                if (isset($result[$index])) {
                    $out = $result[$index];
                } else {
                    $out = null;
                }
            } else {
                foreach ($result as $res) {
                    $out[] = $res;
                }
            }
        } else {
            $out = null;
        }
        return $out;
    }
}

