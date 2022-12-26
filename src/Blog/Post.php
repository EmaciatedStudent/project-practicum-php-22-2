<?php

namespace Tgu\Laperdina\Article;

class Post {
    private UUID $id;
    private string $id_author;
    public string $header;
    public string $text;

    public function __construct($id, $id_author, $header, $text) {
        $this->id = $id;
        $this->id_author = $id_author;
        $this->header = $header;
        $this->text = $text;
    }

    public function __toString(): string {
        $id=$this->getUuidPost();
        return $this->id_author->getUserName() . 'пишет: ' . PHP_EOL . $this->header . PHP_EOL . $this->text;
    }

    public function getUuidPost(): UUID {
        return $this->id;
    }

    public function getUuidUser(): string {
        return $this->id_author;
    }

    public function getTitle(): string {
        return $this->header;
    }

    public function getTextPost(): string {
        return $this->text;
    }
}