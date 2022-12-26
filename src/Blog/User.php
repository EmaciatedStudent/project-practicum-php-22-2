<?php

namespace Tgu\Laperdina\Blog;

use Tgu\Laperdina\Person\Name;

class User {
    private UUID $uuid;
    private Name $name;
    private string $username;

    public function __construct($id, $name, $username) {
        $this->uuid = $id;
        $this->name = $name;
        $this->username = $username;
    }

    public function __toString(): string {
        $uuid = $this->getByUuid();
        $firstName = $this->name->getFirstName();
        $lastName = $this->name->getLastName();

        return "Имя: $firstName $lastName; Логин: $this->username" . PHP_EOL;
    }

    public function getName(): Name {
        return $this->name;
    }

    public function getUsername(): string {
        return $this->username;
    }

    public function getByUuid(): UUID {
        return $this->uuid;
    }
}