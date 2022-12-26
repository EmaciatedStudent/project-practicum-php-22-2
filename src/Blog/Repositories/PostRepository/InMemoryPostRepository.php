<?php

namespace Tgu\Laperdina\Blog\Repositories\PostRepository;

use Tgu\Laperdina\Blog\Post;
use Tgu\Laperdina\Blog\UUID;
use Tgu\Laperdina\Exceptions\PostNotFoundException;

class InMemoryPostRepository implements PostsRepositoryInterface {
    private array $posts = [];

    public function savePost(Post $post): void {
        $this->posts[] = $post;
    }

    public function getByUuidPost(UUID $uuidPost): Post {
        foreach ($this->posts as $post){
            if((string)$post->getUuid() === $uuidPost) {
                return $post;
            }
        }

        throw new PostNotFoundException("Post not found $uuidPost");
    }
}