<?php

namespace Tgu\Laperdina\Blog;

class AuthToken
{
    private string $token;
    private UUID $useruuid;
    private \DateTimeImmutable $expiresOn;

    public function __construct($token, $useruuid, $expiresOn) {
        $this->token = $token;
        $this->useruuid = $useruuid;
        $this->expiresOn = $expiresOn;
    }

    public function getToken(): string {
        return $this->token;
    }

    public function getUseruuid(): UUID {
        return $this->useruuid;
    }

    public function getExpiresOn(): \DateTimeImmutable {
        return $this->expiresOn;
    }

    public function __toString(): string {
        return $this->token;
    }
}