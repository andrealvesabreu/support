<?php
declare(strict_types = 1);
namespace Inspire\Support\Message\System;

/**
 * Description of SystemMessage
 *
 * @author aalves
 *        
 */
class SystemMessage extends Message
{

    /**
     * Constructor
     *
     * @param string $message
     * @param string $systemCode
     * @param int $code
     * @param bool $status
     */
    public function __construct(string $message, string $systemCode, int $code = Message::MSG_OK, ?bool $status = null, ?array $extra = null)
    {
        $this->message = $message;
        $this->systemCode = $systemCode;
        $this->code = $code;
        $this->type = Message::TYPE_SYSTEM;
        if ($status !== null) {
            $this->status = $status;
        } else {
            $this->status = $code == Message::MSG_OK;
        }
        if ($extra !== null) {
            $this->extra = $extra;
        }
        $this->generateUUID(4);
    }
}

