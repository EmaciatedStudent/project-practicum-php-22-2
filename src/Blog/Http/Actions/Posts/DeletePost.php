<?php

namespace Tgu\Laperdina\Blog\Http\Actions\Posts;

use Tgu\Laperdina\Blog\Http\Actions\ActionInterface;
use Tgu\Laperdina\Blog\Http\ErrorResponse;
use Tgu\Laperdina\Blog\Http\Request;
use Tgu\Laperdina\Blog\Http\Response;
use Tgu\Laperdina\Blog\Http\SuccessResponse;
use Tgu\Laperdina\Blog\Repositories\PostRepositories\PostsRepositoryInterface;
use Tgu\Laperdina\Exceptions\HttpException;
use Tgu\Laperdina\Exceptions\PostNotFoundException;

class DeletePost implements ActionInterface
{
    private PostsRepositoryInterface $postsRepository;

    public function __construct ($postsRepository) {
        $this->postsRepository = $postsRepository;
    }
    public function handle(Request $request): Response
    {
        try {
            $uuid = $request->query('uuid_post');
        }

        catch (HttpException | PostNotFoundException $exception){
            return new ErrorResponse($exception->getMessage());
        }

        $this->postsRepository->getByUuidPost($uuid);
        return new SuccessResponse(['uuid_post'=>$uuid]);
    }
}