<?php

namespace Tgu\Laperdina\Blog;

class Comment {
    private UUID $id;
    private string $id_author;
    private string $id_post;
    public string $text;

    public function __construct($id, $autorID, $articleID, $text) {
        $this->id = $id;
        $this->id_author = $autorID;
        $this->id_post = $articleID;
        $this->text = $text;
    }

    public function __toString(): string {
        return $this->id . ' ' .$this->id_author . ' ' .$this->id_post . ' ' . $this->text;
    }

    public function getUuidComment():UUID {
        return $this->id;
    }

    public function getUuidPost(): string {
        return $this->id_post;
    }

    public function getUuidUser(): string {
        return $this->id_author;
    }

    public function getTextComment(): string {
        return $this->text;
    }
}