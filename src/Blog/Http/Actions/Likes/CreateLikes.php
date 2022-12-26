<?php

namespace Tgu\Laperdina\Blog\Http\Actions\Likes;

use Tgu\Laperdina\Blog\Http\Actions\ActionInterface;
use Tgu\Laperdina\Blog\Http\ErrorResponse;
use Tgu\Laperdina\Blog\Http\Request;
use Tgu\Laperdina\Blog\Http\Response;
use Tgu\Laperdina\Blog\Http\SuccessResponse;
use Tgu\Laperdina\Blog\Likes;
use Tgu\Laperdina\Blog\UUID;
use Tgu\Laperdina\Exceptions\HttpException;
use Tgu\Laperdina\Exceptions\PostNotFoundException;
use Tgu\Laperdina\Exceptions\UserNotFoundException;
use Tgu\Laperdina\Blog\Repositories\LikesRepository\LikesRepositoryInterface;
use Tgu\Laperdina\Blog\Http\Auth\TokenAuthenticationInterface;

class CreateLikes implements ActionInterface
{
    private LikesRepositoryInterface $likesRepository;
    private TokenAuthenticationInterface $authentication;

    public function __construct ($likesRepository, $authentication) {
        $this->likesRepository = $likesRepository;
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

        $likeId = UUID::random();
        try {
            $like = new Likes($likeId, $id_post, $id_author);
        }
        catch (HttpException $exception) {
            return new ErrorResponse($exception->getMessage());
        }

        $this->likesRepository->saveLike($like);
        return new SuccessResponse(['uuid_like'=>(string)$likeId]);
    }
}