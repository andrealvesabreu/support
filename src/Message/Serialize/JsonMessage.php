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
        $this->data = json_decode($data, true);
    }
}

