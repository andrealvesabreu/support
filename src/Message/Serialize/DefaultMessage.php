<?php
declare(strict_types = 1);
namespace Inspire\Support\Message\Serialize;

/**
 * Description of DefaultMessage
 *
 * @author aalves
 */
abstract class DefaultMessage
{

    /**
     * Message UUID
     *
     * @var string|NULL
     */
    protected ?string $UUID = null;

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
     * @return string|NULL
     */
    public function getUUID(): ?string
    {
        return $this->UUID;
    }
}