<?php

namespace Tgu\Laperdina\Blog;

class Likes
{
    private UUID $id_like;
    private string $id_post;
    private string $id_user;

    public function __construct($id_like, $id_post, $id_user) {
        $this->id_like = $id_like;
        $this->id_post = $id_post;
        $this->id_user = $id_user;
    }

    public function __toString(): string {
        $id_like= $this->getUuidLike();

        return "Like - $id_like on post $this->id_post where user - $this->id_author".PHP_EOL;
    }

    public function getUuidLike(): UUID {
        return $this->id_like;
    }

    public function getUuidPost(): string {
        return $this->id_post;
    }

    public function getUuidUser(): string {
        return $this->id_user;
    }
}