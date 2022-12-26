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
use Tgu\Laperdina\Exceptions\PostNotFoundException;
use Tgu\Laperdina\Exceptions\UserNotFoundException;
use Tgu\Laperdina\Blog\Http\Auth\TokenAuthenticationInterface;

class CreateComment implements ActionInterface {
    private CommentsRepositoryInterface $commentsRepository;
    private TokenAuthenticationInterface $authentication;

    public function __construct($commentsRepository, $authentication) {
        $this->commentsRepository = $commentsRepository;
        $this->authentication = $authentication;
    }

    public function handle(Request $request): Response {
        try {
            $id_author = $this->authentication->user($request);
        }
        catch (UserNotFoundException $exception) {
            return new ErrorResponse($exception->getMessage());
        }

        try {
            $id_post = $this->authentication->post($request);
        }
        catch (PostNotFoundException $exception) {
            return new ErrorResponse($exception->getMessage());
        }

        $commentId = UUID::random();
        try {
            $comment = new Comment($commentId,
                $id_post,
                $id_author,
                $request->jsonBodyField('textCom')
            );
        }
        catch (HttpException $exception) {
            return new ErrorResponse($exception->getMessage());
        }

        $this->commentsRepository->saveComment($comment);
        return new SuccessResponse(['uuid_comment'=>(string)$commentId]);
    }
}