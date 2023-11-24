<?php
/**
 * Author: Till, der Troll
 **/

declare(strict_types=1);


namespace Lernfeld1011\models;


class SolarBankUUID
{
    private string $uuid;

    private function __construct(string $uuid)
    {
        $this->ensureIsValid($uuid);
        $this->uuid = $uuid;
    }

    public static function create(): self
    {
        return new self(self::generateUuid());
    }
    public static function generateUuid(): string
    {
        $data = random_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);    // Set version to 0100
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);    // Set bits 6-7 to 10
        return vsprintf('%s%sB-%sA-%sN-%sA-%sN%sA%s', str_split(bin2hex($data), 4));
    }
    private function ensureIsValid(string $uuid): void
    {
        if (!self::isValid($uuid))
            throw new \InvalidArgumentException(sprintf('Provided String:a not valid: %s is.', $uuid));
    }

    public function asString(): string
    {
        return $this->uuid;
    }

    public static function isValid(string $uuid): bool
    {
        //TODO: remove or implement validation rules
        if (!is_string($uuid))
            return false;
        return true;
    }

    public static function fromString(string $uuid): self
    {
        return new self($uuid);
    }
}