<?php

declare(strict_types=1);

namespace Inspire\Support\Message\System;

use Inspire\Support\Arrays;

/**
 * Description of Message
 *
 * @author aalves
 */
abstract class Message
{

    // System message type
    const TYPE_SYSTEM = 1;

    // HTTP message type
    const TYPE_HTTP = 2;

    // Exception message type
    const TYPE_EXCEPTION = 3;

    // Code for emergency
    const MSG_EMERGENCY = 0;

    // Code for alert
    const MSG_ALERT = 1;

    // Code for critical error
    const MSG_CRITICAL = 2;

    // Code for general error
    const MSG_ERROR = 3;

    // Code for warnings
    const MSG_WARNING = 4;

    // Code for notices
    const MSG_NOTICE = 5;

    // Code for infos
    const MSG_INFO = 6;

    // Code for debug
    const MSG_DEBUG = 7;

    // Code for ok message interchange (default)
    const MSG_OK = 10;

    /**
     * Message code
     *
     * @var int
     */
    protected int $code = Message::MSG_OK;

    /**
     * Message type
     *
     * @var int
     */
    protected ?int $type = null;

    /**
     * Message text
     *
     * @var string|null
     */
    protected ?string $message = null;

    /**
     * Code tranliterable for system
     *
     * @var string|null
     */
    protected ?string $systemCode = null;

    /**
     * Code tranliterable for system
     *
     * @var bool|null
     */
    protected ?bool $status = null;

    /**
     * Extra data
     *
     * @var array|NULL
     */
    protected ?array $extra = null;

    /**
     * Message UUID
     *
     * @var string|NULL
     */
    protected ?string $UUID = null;

    /**
     *
     * @var boolean
     */
    protected static $generateUuid = true;

    /**
     * Generate an UUID for message
     *
     * @param int $version
     * @throws \RuntimeException
     */
    protected function generateUUID(int $version)
    {
        if ($version > 0 && $version < 7) {
            $method = "Uuid{$version}";
            $this->UUID = (call_user_func([
                '\\Ramsey\\Uuid\\Uuid',
                $method
            ]))->toString();
        } else {
            throw new \RuntimeException("Unespected UUID version: {$version}");
        }
    }

    /**
     *
     * @return Message|array|\RuntimeException
     */
    public function getMessage()
    {
        switch ($this->type) {
            case Message::TYPE_SYSTEM:
                return SystemMessage::get($this);
            case Message::TYPE_HTTP:
                return HttpMessage::get($this);
            case Message::TYPE_EXCEPTION:
                return ExceptionMessage::get($this);
            default:
                throw new \RuntimeException("Unespected message type: {$this->type}");
        }
    }

    /**
     *
     * @param bool $useUuid
     */
    public static function useUuid(bool $useUuid)
    {
        Message::$generateUuid = $useUuid;
    }

    /**
     * Return message as array
     *
     * @param Message $message
     * @return array
     */
    protected function get(Message $message): array
    {
        return [
            'code' => $message->code,
            'message' => $message->message,
            'sys_code' => $message->systemCode,
            'status' => $message->status,
            'extra' => $message->extra ?? null,
            'uuid' => $message->UUID
        ];
    }

    /**
     * Get message type
     *
     * @return int|NULL
     */
    public function getType(): ?int
    {
        return $this->type;
    }

    /**
     * Get message code
     *
     * @return int|NULL
     */
    public function getCode(): ?int
    {
        return $this->code;
    }

    /**
     * Get message system code
     *
     * @return string|NULL
     */
    public function getSystemCode(): ?string
    {
        return $this->systemCode;
    }

    /**
     * Get message text
     *
     * @return string|NULL
     */
    public function __toString(): string
    {
        return $this->message;
    }

    /**
     * Get extra data
     *
     * @param string $index
     * @return array|NULL|mixed|array[]
     */
    public function getExtra(?string $index = null)
    {
        if ($index === null) {
            return $this->extra;
        }
        return Arrays::get($this->extra, $index, null);
    }

    /**
     * Set extra data
     *
     * @param array $extra
     */
    public function setExtra(string $extra, $value)
    {
        Arrays::set($this->extra, $extra, $value);
    }

    /**
     * Set extra data from array
     *
     * @param array $extra
     */
    public function setExtras(array $extra)
    {
        foreach ($extra as $k => $v) {
            Arrays::set($this->extra, $k, $v);
        }
    }

    /**
     * Add extra data
     *
     * @param array $extra
     */
    public function addExtra(string $extra, $value)
    {
        $this->extra = Arrays::add($this->extra, $extra, $value);
    }

    /**
     * Add extra data from array
     *
     * @param array $extra
     */
    public function addExtras(array $extra)
    {
        foreach ($extra as $k => $v) {
            $this->extra = Arrays::add($this->extra, $k, $v);
        }
    }

    /**
     * Get message status
     *
     * @return bool|null
     */
    public function isOk(): ?bool
    {
        return $this->status;
    }
}
