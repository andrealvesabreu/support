<?php

declare(strict_types=1);

namespace Inspire\Support\Message\Serialize;

use Inspire\Support\Arrays;

/**
 * Description of ArrayMessage
 *
 * @author aalves
 */
class ArrayMessage extends DefaultMessage implements MessageInterface
{

    protected $data = [];

    /**
     * Constructor can receive data serialized or array
     * 
     * @param mixed $data
     */
    public function __construct($data, $uuid = false)
    {
        if (is_array($data)) {
            $this->data = $data;
        } else if (is_string($data) && !empty($data)) {
            $this->data = unserialize($data);
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
     * Serialize object
     *
     * @return string|null
     */
    public function serialize(): ?string
    {
        return serialize($this->data);
    }

    /**
     * Unserialize data, returning a new instance of this class
     *
     * @param [type] $data
     * @return ArrayMessage
     */
    public static function unserialize($data): ArrayMessage
    {
        return new static($data);
    }

    /**
     * Set an array item to a given value using "dot" notation.
     *
     * @param string $field
     * @param [type] $value
     * @return array|null
     */
    public function set(string $field, $value): ?array
    {
        return Arrays::set($this->data, $field, $value);
    }

    /**
     * Set all elements of input array in an array item to a given value using "dot" notation.
     *
     * @param array $list
     * @return array|null
     */
    public function setList(array $list): ?array
    {
        foreach ($list as $k => $v) {
            Arrays::set($this->data, $k, $v);
        }
        return $this->data;
    }

    /**
     * Return entire object data
     *
     * @return void
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get data from array using "dot" notation
     *
     * @param string $field
     * @param [type] $default
     * @return void
     */
    public function get(string $field, $default = null)
    {
        return Arrays::get($this->data, $field, $default);
    }

    /**
     * Add a key => value pair to array, if it does not exists
     *
     * @param string $field
     * @param [type] $value
     * @return void
     */
    public function add(string $field, $value)
    {
        return Arrays::add($this->data, $field, $value);
    }

    /**
     * Add multiple items to array, if keys does not exists
     *
     * @param array $list
     * @return void
     */
    public function addList(array $list)
    {
        foreach ($list as $k => $v) {
            Arrays::set($this->data, $k, $v);
        }
    }

    /**
     * Clear all data of object
     *
     * @return void
     */
    public function clear()
    {
        $this->data = [];
    }
}
