<?php

declare(strict_types=1);

namespace Inspire\Support\Message\Serialize;

/**
 * Description of MessageInterface
 *
 * @author aalves
 */
interface MessageInterface
{

    /**
     * Constructor
     *
     * @param mixed $data
     */
    public function __construct($data);

    /**
     * Serialize all data as string
     *
     * @return string|NULL
     */
    public function serialize(): ?string;

    /**
     * Unserialize data and populate its properties
     *
     * @param mixed $data
     */
    public static function unserialize($data): DefaultMessage;

    /**
     * Get all data
     */
    public function getData();

    /**
     * Get data from specified field
     *
     * @param string $field
     * @param string $default
     */
    public function get(string $field, ?string $default = null);

    /**
     * Set data to specified field, replacing its original contents
     *
     * @param string $field
     * @param mixed $value
     */
    public function set(string $field, $value);

    /**
     * Set multiple itens, replacing its original contents
     *
     * @param string $field
     * @param mixed $value
     */
    public function setList(array $data);

    /**
     * Add data to specified field, preserving another informations in same path
     *
     * @param string $field
     * @param mixed $value
     */
    public function add(string $field, $value);

    /**
     * Add multiple itens
     *
     * @param string $field
     * @param mixed $value
     */
    public function addList(array $data);

    /**
     * Reset all message data
     */
    public function clear();
}
