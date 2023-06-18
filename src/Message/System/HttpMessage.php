<?php

declare(strict_types=1);

namespace Inspire\Support\Message\System;

/**
 *
 * @author aalves
 *        
 */
class HttpMessage extends Message
{

    /**
     * Constructor
     *
     * @param string $message
     * @param string $systemCode
     * @param int $code
     */
    public function __construct(string $message, string $systemCode, int $code = 200, ?bool $status = null, ?array $extra = null)
    {
        $this->message = $message;
        $this->systemCode = $systemCode;
        $this->code = $code;
        $this->type = Message::TYPE_HTTP;
        if ($status !== null) {
            $this->status = $status;
        } else {
            $this->status = $code == 200;
        }
        if ($extra !== null) {
            $this->extra = $extra;
        }
        if (Message::$generateUuid) {
            $this->generateUUID(4);
        }
    }
}
