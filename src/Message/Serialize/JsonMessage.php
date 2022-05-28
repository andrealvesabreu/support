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
        $this->data = json_decode($data, true);
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
}

