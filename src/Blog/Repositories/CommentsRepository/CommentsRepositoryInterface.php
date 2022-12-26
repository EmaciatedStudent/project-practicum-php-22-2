<?php

namespace Tgu\Laperdina\Blog\Repositories\CommentsRepository;


use Tgu\Laperdina\Blog\Comment;
use Tgu\Laperdina\Blog\UUID;

interface CommentsRepositoryInterface
{
    public function saveComment(Comment $comment): void;

    public function getByUuidComment(UUID $uuid_comment): Comment;
}