<?php

namespace Tgu\Laperdina\Blog;

use Tgu\Laperdina\Person\Name;

class User {
    private UUID $uuid;
    private Name $name;
    private string $username;
    private string $hashPassword;

    public function __construct($id, $name, $username, $hashPassword) {
        $this->uuid = $id;
        $this->name = $name;
        $this->username = $username;
        $this->hashPassword = $hashPassword;
    }

    public function __toString(): string {
        $uuid = $this->getUuid();
        $firstName = $this->name->getFirstName();
        $lastName = $this->name->getLastName();

        return "UUID: $uuid; Имя: $firstName $lastName; Логин: $this->username" . PHP_EOL;
    }

    public function getName(): Name {
        return $this->name;
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function getUuid(): UUID {
        return $this->uuid;
    }

    public function gethashPassword(): string {
        return $this->hashPassword;
    }

    public static function hash(string $password, UUID $uuid): string {
        return hash('sha256', $uuid . $password);
    }

    public function checkPassword(string $password): bool {
        return $this->hashPassword ===self::hash($password, $this->uuid);
    }

    public static function createFrom(string $username, string $password, Name $name): self {
        $uuid = UUID::random();
        return new self( $uuid, $name, $username, self::hash($password, $uuid));
    }
}