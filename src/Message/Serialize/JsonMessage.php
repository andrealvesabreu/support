<?php
declare(strict_types = 1);
namespace Inspire\Support\Message\Serialize;

/**
 * Description of JsonMessage
 *
 * @author aalves
 */
class JsonMessage extends ArrayMessage implements MessageInterface
{

    /**
     *
     * {@inheritdoc}
     * @see \Inspire\Support\Message\Serialize\ArrayMessage::serialize()
     */
    public function serialize(): ?array
    {
        $unserialized = json_encode($this->data, JSON_UNESCAPED_UNICODE);
        return ! is_array($unserialized) && ! empty($unserialized) ? [
            $unserialized
        ] : [];
    }

    /**
     *
     * PHP 8.1 support
     *
     * {@inheritdoc}
     * @see \Inspire\Support\Message\Serialize\MessageInterface::__serialize()
     */
    public function __serialize(): array
    {
        return $this->serialize() ?? [];
    }

    /**
     *
     * {@inheritdoc}
     * @see \Inspire\Support\Message\Serialize\ArrayMessage::unserialize()
     */
    public function unserialize($data): void
    {
        $this->data = json_decode($data, true);
    }

    /**
     * PHP 8.1 support
     *
     * {@inheritdoc}
     * @see \Inspire\Support\Message\Serialize\MessageInterface::__unserialize()
     */
    public function __unserialize($data): void
    {
        $this->__unserialize($data);
    }
}

