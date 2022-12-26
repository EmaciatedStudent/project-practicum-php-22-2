<?php

namespace Tgu\Laperdina\Blog\Repositories\PostRepository;

use Tgu\Laperdina\Blog\Post;
use Tgu\Laperdina\Blog\UUID;

interface PostRepositoryInterface {
    public function savePost(Post $post): void;

    public function getByUuidPost(UUID $uuidPost): Post;

    public function getTextPost(string $text): Post;
}