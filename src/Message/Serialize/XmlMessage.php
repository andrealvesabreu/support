<?php
declare(strict_types = 1);
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
    public function __construct($data)
    {
        $this->data = \Inspire\Support\Xml\XML2Array::createArray($data);
        $this->generateUUID(4);
    }

    /**
     *
     * {@inheritdoc}
     * @see \Inspire\Support\Message\Serialize\ArrayMessage::serialize()
     */
    public function serialize(): ?string
    {
        return json_encode($this->data, JSON_UNESCAPED_UNICODE);
    }

    /**
     *
     * PHP 8.1 support
     *
     * {@inheritdoc}
     * @see \Inspire\Support\Message\Serialize\MessageInterface::serialize()
     */
    public function __serialize(): ?string
    {
        return $this->serialize();
    }

    /**
     *
     * {@inheritdoc}
     * @see \Inspire\Support\Message\Serialize\ArrayMessage::unserialize()
     */
    public function unserialize($data)
    {
        if ($this->load($data)) {
            $this->data = $this->xml;
        } else {
            $this->data = null;
        }
    }

    /**
     * PHP 8.1 support
     *
     * {@inheritdoc}
     * @see \Inspire\Support\Message\Serialize\MessageInterface::unserialize()
     */
    public function __unserialize($data)
    {
        $this->__unserialize($data);
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