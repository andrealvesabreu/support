<?php

declare(strict_types=1);

namespace Inspire\Support\Message\Serialize;

/**
 * Description of JsonMessage
 *
 * @author aalves
 */
class JsonMessage extends ArrayMessage implements MessageInterface
{

    /**
     * Constructor can receive data serialized or array
     * 
     * @param mixed $data
     */
    public function __construct($data, $uuid = false)
    {
        if (is_string($data) && !empty($data)) {
            $data = json_decode($data, true);
        }
        parent::__construct($data, $uuid);
    }
    /**
     * Serialize object
     *
     * @return string|null
     */
    public function serialize(): ?string
    {
        return json_encode($this->data, JSON_UNESCAPED_UNICODE);
    }

    /**
     * Unserialize data, returning a new instance of this class
     *
     * @param [type] $data
     * @return JsonMessage
     */
    public static function unserialize($data): JsonMessage
    {
        return new static($data);
    }
}
