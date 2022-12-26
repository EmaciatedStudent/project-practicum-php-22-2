<?php

namespace Tgu\Laperdina\Person;

use DateTimeImmutable;

class Person {
    private Name $name;
    private DateTimeImmutable  $registeredOn;

    public function __construct($name, $date) {
        $this->name = $name;
        $this->registeredOn = $date;
    }

    public function __toString(): string
    {
        return $this->name . ' на сайте с ' . $this->registeredOn->format('Y-m-d');
    }
}