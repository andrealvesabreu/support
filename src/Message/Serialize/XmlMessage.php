<?php

declare(strict_types=1);

namespace Inspire\Support\Message\Serialize;

use Inspire\Support\Xml\Array2XML;
use Inspire\Support\Xml\Xml;

/**
 * Description of XmlMessage
 *
 * @author aalves
 */
class XmlMessage extends ArrayMessage implements MessageInterface
{

    /**
     *
     * @param mixed $data
     */
    public function __construct($data, $uuid = false)
    {
        if (is_array($data)) {
            $this->data = $data;
        } else if (is_string($data) && !empty($data)) {
            $this->data = \Inspire\Support\Xml\XML2Array::createArray($data);
        }
        /**
         * Generate UUID for message
         */
        if ($uuid !== false) {
            if (is_int($uuid)) {
                $uuid_version = intval($uuid);
                if ($uuid_version > 0 && $uuid_version < 6) {
                    $this->generateUUID($uuid_version);
                } else {
                    $this->generateUUID(4);
                }
            } else {
                $this->generateUUID(4);
            }
        }
    }

    /**
     * Serialize object (return XML compiled)
     *
     * @return string|null
     */
    public function serialize(): ?string
    {
        return \Inspire\Support\Xml\Xml::arrayToXml($this->data);
    }

    /**
     * Unserialize data, returning a new instance of this class
     *
     * @param [type] $data
     * @return XmlMessage
     */
    public static function unserialize($data): XmlMessage
    {
        return new static($data);
    }

    /**
     * Return XML with array data
     *
     * @param string $root
     * @param bool $asXmlObj
     * @return \Inspire\Support\Xml\Xml|string
     */
    public function toXml(?string $root = null, bool $asXmlObj = false)
    {
        $data = $this->data;
        if (($root === null || empty($root)) && count($data) == 1) {
            $root = array_keys($data)[0];
            $data = $data[$root];
        }
        $xml = Array2XML::createXML($root, $data)->saveXML();
        if ($asXmlObj) {
            return new Xml($xml);
        }
        return $xml;
    }
}
