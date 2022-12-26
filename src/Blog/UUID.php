<?php

namespace Tgu\Laperdina\Blog;

use Tgu\Laperdina\Exceptions\InvalidArgumentException;

class UUID
{
    private string $uuid;

    public function __construct($uuid)
    {
        $this->uuid = $uuid;

        if (!uuid_is_valid($uuid)) {
            throw new InvalidArgumentException("Malformed UUID: $this->uuid");
        }
    }

    public function __toString(): string {
        return $this->uuid;
    }

    public static function random(): self {
        return new self(uuid_create(UUID_TYPE_RANDOM));
    }
}