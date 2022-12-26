<?php
namespace Tgu\Laperdina\Blog\Repositories\LikesRepository;

use Tgu\Laperdina\Blog\Likes;

interface LikesRepositoryInterface {
    public function saveLike(Likes $comment): void;

    public function getByPostUuid(string $uuid_post): Likes;
}