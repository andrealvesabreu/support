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
     * @param mixed $data
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Inspire\Support\Message\Serialize\MessageInterface::serialize()
     */
    public function serialize(): ?string
    {
        return serialize($this->data);
    }

    /**
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
    public function set(string $field, $value): ?array
    {
        return Arrays::set($this->data, $field, $value);
    }

    /**
     * Set field in data
     *
     * {@inheritdoc}
     * @see \Inspire\Support\Message\Serialize\MessageInterface::setList()
     */
    public function setList(array $list): ?array
    {
        foreach ($list as $k => $v) {
            Arrays::set($this->data, $k, $v);
        }
    }

    /**
     *
     * {@inheritdoc}
     * @see \Inspire\Support\Message\Serialize\MessageInterface::getData()
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     *
     * {@inheritdoc}
     * @see \Inspire\Support\Message\Serialize\MessageInterface::get()
     */
    public function get(string $field, ?string $default = null)
    {
        return Arrays::get($this->data, $field, $default);
    }

    /**
     *
     * {@inheritdoc}
     * @see \Inspire\Support\Message\Serialize\MessageInterface::add()
     */
    public function add(string $field, $value)
    {
        return Arrays::add($this->data, $field, $value);
    }

    /**
     *
     * {@inheritdoc}
     * @see \Inspire\Support\Message\Serialize\MessageInterface::addList()
     */
    public function addList(array $list)
    {
        foreach ($list as $k => $v) {
            Arrays::set($this->data, $k, $v);
        }
    }

    /**
     *
     * {@inheritdoc}
     * @see \Inspire\Support\Message\Serialize\MessageInterface::clear()
     */
    public function clear()
    {
        $this->data = [];
    }
}

