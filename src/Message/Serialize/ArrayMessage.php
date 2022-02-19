<?php
declare(strict_types = 1);
namespace Inspire\Support\Message\Serialize;

use Inspire\Support\Arrays;

/**
 * Description of ArrayMessage
 *
 * @author aalves
 */
class ArrayMessage extends DefaultMessage implements MessageInterface, \Serializable
{

    protected $data = [];

    /**
     *
     * @param array $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Return constents serialized as JSON
     *
     * {@inheritdoc}
     * @see \Inspire\Support\Message\Serialize\MessageInterface::serialize()
     */
    public function serialize(): ?string
    {
        return serialize($this->data);
    }

    /**
     * Desserialize JSON data
     *
     * {@inheritdoc}
     * @see \Inspire\Support\Message\Serialize\MessageInterface::unserialize()
     */
    public function unserialize($data)
    {
        $this->data = unserialize($data);
    }

    /**
     * Set field in data
     *
     * {@inheritdoc}
     * @see \Inspire\Support\Message\Serialize\MessageInterface::set()
     */
    public function set(string $field, string $value): ?array
    {
        return Arrays::set($this->data, $field, $value);
    }

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

    /**
     * Return data from specified field
     *
     * {@inheritdoc}
     * @see \Inspire\Support\Message\Serialize\MessageInterface::get()
     */
    public function get(string $field, ?string $default = null)
    {
        return Arrays::get($this->data, $field, $default);
    }

    /**
     * Add field in data if it does't exists
     *
     * {@inheritdoc}
     * @see \Inspire\Support\Message\Serialize\MessageInterface::add()
     */
    public function add(string $field, string $value)
    {
        return Arrays::add($this->data, $field, $value);
    }
}

