<?php

namespace Tgu\Laperdina\Blog\Http;

class SuccessResponse extends Response {
    protected const SUCCESS = true;
    public array $data;

    public function __construct($data = []) {
        $this->data = $data;
    }

    function payload(): array {
        return ['data'=>$this->data];
    }
}