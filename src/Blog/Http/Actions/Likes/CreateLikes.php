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

class CreateLikes implements ActionInterface
{
    private LikesRepositoryInterface $likesRepository;

    public function __construct ($likesRepository) {
        $this->likesRepository = $likesRepository;
    }

    public function handle(Request $request): Response {
        try {
            $newLikeUuid = UUID::random();
            $like= new Likes($newLikeUuid, $request->jsonBodyFind('uuid_post'), $request->jsonBodyFind('uuid_user'));
        }

        catch (HttpException $exception) {
            return new ErrorResponse($exception->getMessage());
        }

        $this->likesRepository->saveLike($like);
        return new SuccessResponse(['uuid_like'=>(string)$newLikeUuid]);
    }
}