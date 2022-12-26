<?php

namespace Tgu\Laperdina\Blog\Http\Actions\Posts;

use Tgu\Laperdina\Blog\Http\Actions\ActionInterface;
use Tgu\Laperdina\Blog\Http\ErrorResponse;
use Tgu\Laperdina\Blog\Http\Request;
use Tgu\Laperdina\Blog\Http\Response;
use Tgu\Laperdina\Blog\Http\SuccessResponse;
use Tgu\Laperdina\Blog\Post;
use Tgu\Laperdina\Blog\Repositories\PostRepository\PostsRepositoryInterface;
use Tgu\Laperdina\Blog\UUID;
use Tgu\Laperdina\Exceptions\HttpException;

class CreatePost implements ActionInterface {
    private PostsRepositoryInterface $postsRepository;

    public function __construct ($postsRepository)
    {
        $this->postsRepository = $postsRepository;
    }

    public function handle(Request $request): Response {
        try {
            $newPostUuid = UUID::random();
            $post = new Post($newPostUuid,
                $request->jsonBodyFind('uuid_author'),
                $request->jsonBodyFind('title'),
                $request->jsonBodyFind('text'));
        }

        catch (HttpException $exception){
            return new ErrorResponse($exception->getMessage());
        }

        $this->postsRepository->savePost($post);
        return new SuccessResponse(['uuid_post'=>$newPostUuid]);
    }
}