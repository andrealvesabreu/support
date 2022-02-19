<?php
declare(strict_types = 1);
namespace Inspire\Support\Message\Serialize;

/**
 * Description of CustomMessage
 *
 * @author aalves
 */
class CustomMessage extends DefaultMessage implements MessageInterface, \Serializable
{

    public function __construct($data)
    {}

    public function serialize($data)
    {}

    public function unserialize(string $data)
    {}

    /**
     * Get all data
     *
     * {@inheritdoc}
     * @see \Inspire\Support\Message\Serialize\MessageInterface::getData()
     */
    public function getData()
    {
        return $this->data;
    }

    public function set(string $field, string $value)
    {}

    public function get(string $field)
    {}

    public function add(string $field, string $value)
    {}
}

