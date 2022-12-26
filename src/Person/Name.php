<?php

namespace  Tgu\Laperdina\Person;

class Name {
    private string $firstname;
    private string $lastname;

    public function  __construct($firstname, $lastname) {
        $this->firstname = $firstname;
        $this->lastname = $lastname;
    }

    public function __toString(): string {
        return $this->firstname . ' ' . $this->lastname;
    }

    public function getFirstName(): string {
        return $this->firsrname;
    }

    public function getLastName(): string {
        return $this->lastname;
    }
}