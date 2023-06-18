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

    // HTTP codes
    const HTTP_100 = 100;
    const HTTP_101 = 101;
    const HTTP_102 = 102;
    const HTTP_200 = 200;
    const HTTP_201 = 201;
    const HTTP_202 = 202;
    const HTTP_203 = 203;
    const HTTP_204 = 204;
    const HTTP_205 = 205;
    const HTTP_206 = 206;
    const HTTP_207 = 207;
    const HTTP_208 = 208;
    const HTTP_226 = 226;
    const HTTP_300 = 300;
    const HTTP_301 = 301;
    const HTTP_302 = 302;
    const HTTP_303 = 303;
    const HTTP_304 = 304;
    const HTTP_305 = 305;
    const HTTP_307 = 307;
    const HTTP_308 = 308;
    const HTTP_400 = 400;
    const HTTP_401 = 401;
    const HTTP_402 = 402;
    const HTTP_403 = 403;
    const HTTP_404 = 404;
    const HTTP_405 = 405;
    const HTTP_406 = 406;
    const HTTP_407 = 407;
    const HTTP_408 = 408;
    const HTTP_409 = 409;
    const HTTP_410 = 410;
    const HTTP_411 = 411;
    const HTTP_412 = 412;
    const HTTP_413 = 413;
    const HTTP_414 = 414;
    const HTTP_415 = 415;
    const HTTP_416 = 416;
    const HTTP_417 = 417;
    const HTTP_418 = 418;
    const HTTP_421 = 421;
    const HTTP_422 = 422;
    const HTTP_423 = 423;
    const HTTP_424 = 424;
    const HTTP_426 = 426;
    const HTTP_428 = 428;
    const HTTP_429 = 429;
    const HTTP_431 = 431;
    const HTTP_444 = 444;
    const HTTP_451 = 451;
    const HTTP_499 = 499;
    const HTTP_500 = 500;
    const HTTP_501 = 501;
    const HTTP_502 = 502;
    const HTTP_503 = 503;
    const HTTP_504 = 504;
    const HTTP_505 = 505;
    const HTTP_506 = 506;
    const HTTP_507 = 507;
    const HTTP_508 = 508;
    const HTTP_510 = 510;
    const HTTP_511 = 511;
    const HTTP_599 = 599;

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

    /**
     * Get http message for message code
     *
     * @return string
     */
    public function getHttpMessage(?int $code = null)
    {
        return $this->transliterateCode[$code ?? $this->code] ?? 'Unknow message code';
    }

    /**
     * List of codes from where parse specific message
     * App must be designed using this codes
     *
     * @var array
     */
    protected $transliterateCode = [
        500 => 'Internal Server Error',
        501 => 'Not Implemented',
        502 => 'Bad Gateway',
        503 => 'Service Unavailable',
        504 => 'Gateway Timeout',
        505 => 'HTTP Version Not Supported',
        506 => 'Variant Also Negotiates',
        507 => 'Insufficient Storage',
        508 => 'Loop Detected',
        510 => 'Not Extended',
        511 => 'Network Authentication Required',
        599 => 'Network Connect Timeout Error',
        100 => 'Continue',
        101 => 'Switching Protocols',
        102 => 'Processing',
        200 => 'OK',
        201 => 'Created',
        202 => 'Accepted',
        203 => 'Non-authoritative Information',
        204 => 'No Content',
        205 => 'Reset Content',
        206 => 'Partial Content',
        207 => 'Multi-Status',
        208 => 'Already Reported',
        226 => 'IM Used',
        300 => 'Multiple Choices',
        301 => 'Moved Permanently',
        302 => 'Found',
        303 => 'See Other',
        304 => 'Not Modified',
        305 => 'Use Proxy',
        307 => 'Temporary Redirect',
        308 => 'Permanent Redirect',
        400 => 'Bad Request',
        401 => 'Unauthorized',
        402 => 'Payment Required',
        403 => 'Forbidden',
        404 => 'Not Found',
        405 => 'Method Not Allowed',
        406 => 'Not Acceptable',
        407 => 'Proxy Authentication Required',
        408 => 'Request Timeout',
        409 => 'Conflict',
        410 => 'Gone',
        411 => 'Length Required',
        412 => 'Precondition Failed',
        413 => 'Payload Too Large',
        414 => 'Request-URI Too Long',
        415 => 'Unsupported Media Type',
        416 => 'Requested Range Not Satisfiable',
        417 => 'Expectation Failed',
        418 => 'I\'m a teapot',
        421 => 'Misdirected Request',
        422 => 'Unprocessable Entity',
        423 => 'Locked',
        424 => 'Failed Dependency',
        426 => 'Upgrade Required',
        428 => 'Precondition Required',
        429 => 'Too Many Requests',
        431 => 'Request Header Fields Too Large',
        444 => 'Connection Closed Without Response',
        451 => 'Unavailable For Legal Reasons',
        499 => 'Client Closed Request'
    ];
}
