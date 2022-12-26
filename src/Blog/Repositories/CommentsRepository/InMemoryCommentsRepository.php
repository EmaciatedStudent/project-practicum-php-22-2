<?php

namespace Tgu\Laperdina\Blog\Repositories\CommentsRepository;

use Tgu\Laperdina\Blog\Comment;
use Tgu\Laperdina\Blog\UUID;
use Tgu\Laperdina\Exceptions\CommentNotFoundException;

class InMemoryCommentsRepository implements CommentsRepositoryInterface
{
    private array $comments = [];

    public function saveComment(Comment $comment): void {
        $this->comments[] = $comment;
    }

    public function getByUuidComment(UUID $uuid_comment): Comment {
        foreach ($this->comments as $comment){
            if((string)$comment->getUuid() === $uuid_comment)
                return $comment;
        }

        throw new CommentNotFoundException("Users not found $uuid_comment");
    }
}