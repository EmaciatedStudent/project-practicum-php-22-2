<?php

namespace Tgu\Laperdina\Comment;

class Comment {
    private $id;
    private $autorID;
    private $articleID;
    public $content;

    public function __construct($id, $autorID, $articleID, $content) {
        $this->id = $id;
        $this->autorID = $autorID;
        $this->articleID = $articleID;
        $this->content = $content;
    }
}