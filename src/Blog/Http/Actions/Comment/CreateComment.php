<?php

namespace Tgu\Laperdina\Blog\Http\Actions\Comments;

use Tgu\Laperdina\Blog\Comments;
use Tgu\Laperdina\Blog\Http\Actions\ActionInterface;
use Tgu\Laperdina\Blog\Http\ErrorResponse;
use Tgu\Laperdina\Blog\Http\Request;
use Tgu\Laperdina\Blog\Http\Response;
use Tgu\Laperdina\Blog\Http\SuccessResponse;
use Tgu\Laperdina\Blog\Repositories\CommentsRepository\CommentsRepositoryInterface;
use Tgu\Laperdina\Blog\UUID;
use Tgu\Laperdina\Exceptions\HttpException;

class CreateComment implements ActionInterface {
    private CommentsRepositoryInterface $commentsRepository;

    public function __construct($commentsRepository) {
        $this->commentsRepository = $commentsRepository;
    }

    public function handle(Request $request): Response {
        try {
            $newCommentUuid = UUID::random();
            $comment = new Comments($newCommentUuid,
                $request->jsonBodyFind('id_post'),
                $request->jsonBodyFind('id_author'),
                $request->jsonBodyFind('text'));
        }

        catch (HttpException $exception) {
            return new ErrorResponse($exception->getMessage());
        }

        $this->commentsRepository->saveComment($comment);
        return new SuccessResponse(['id'=>(string)$newCommentUuid]);
    }
}