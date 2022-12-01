<?php

namespace Tgu\Laperdina\Article;

class Article {
    private $id;
    private $autorID;
    public $title;
    public $content;

    public function __construct($id, $autorID, $title, $content) {
        $this->id = $id;
        $this->autorID = $autorID;
        $this->title = $title;
        $this->content = $content;
    }
}