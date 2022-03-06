<?php
declare(strict_types = 1);
namespace Inspire\Support\Message\Serialize;

/**
 * Description of XmlMessage
 *
 * @author aalves
 */
class XmlMessage extends ArrayMessage implements MessageInterface
{

    /**
     *
     * @param XML $data
     */
    public function __construct($data)
    {
        $this->data = \Inspire\Support\Xml\XML2Array::createArray($data);
    }

    /**
     * Return constents serialized as JSON
     *
     * {@inheritdoc}
     * @see \Inspire\Support\Message\Serialize\MessageInterface::serialize()
     */
    public function serialize(): ?string
    {
        return json_encode($this->data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * Desserialize JSON data
     *
     * {@inheritdoc}
     * @see \Inspire\Support\Message\Serialize\MessageInterface::unserialize()
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
     * Convert array to XML
     *
     * @return string XML
     */
    public function toXml(): ?string
    {
        $root = array_keys($this->data)[0];
        return \Inspire\Support\Xml\Array2XML::createXML($root, $this->data[$root])->saveXML();
    }
}