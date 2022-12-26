<?php

namespace Tgu\Laperdina\PhpUnit\Blog\Container;

class SomeClassWithParameter
{
    private int $value;

    public function __construct($value) {
        $this->value = $value;
    }

    public function geyValue(): int {
        return $this->value;
    }
}