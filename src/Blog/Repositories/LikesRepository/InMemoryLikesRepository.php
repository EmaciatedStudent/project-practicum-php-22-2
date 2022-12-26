<?php

namespace Tgu\Laperdina\Blog\Repositories\LikesRepository;

use Tgu\Laperdina\Blog\Likes;
use Tgu\Laperdina\Exceptions\LikeNotFoundException;

class InMemoryLikesRepository implements LikesRepositoryInterface {
    private array $likes = [];

    public function saveLike(Likes $likes): void {
        $this->likes[] = $likes;
    }

    public function getByPostUuid(string $uuid_post): Likes {
        foreach ($this->likes as $like) {
            if((string)$like->getUuidPost() === $uuid_post) {
                return $like;
            }
        }

        throw new LikeNotFoundException("Like not found $uuid_post");
    }
}