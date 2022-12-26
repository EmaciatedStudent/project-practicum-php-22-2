<?php

namespace Tgu\Laperdina\PhpUnit\Blog\Container;

class SomeClassDependingOnAnother {
    public SomeClassWithoutDependencies $one;
    public SomeClassWithParameter $two;

    public function __construct($one, $two)
    {
        $this->one = $one;
        $this->two = $two;
    }
}