<?php

namespace Tgu\Laperdina\Blog\Http\Actions\Posts;

use Tgu\Laperdina\Blog\Http\Actions\ActionInterface;
use Tgu\Laperdina\Blog\Http\ErrorResponse;
use Tgu\Laperdina\Blog\Http\Request;
use Tgu\Laperdina\Blog\Http\Response;
use Tgu\Laperdina\Blog\Http\SuccessResponse;
use Tgu\Laperdina\Blog\Repositories\PostRepository\PostsRepositoryInterface;
use Tgu\Laperdina\Blog\UUID;
use Tgu\Laperdina\Exceptions\HttpException;
use Tgu\Laperdina\Exceptions\PostNotFoundException;

class CreatePosts implements ActionInterface
{
    private PostsRepositoryInterface $postsRepository;

    public function __construct($postsRepository) {
        $this->postsRepository = $postsRepository;
    }

    public function handle(Request $request): Response {
        try {
            $uuid = UUID::random();
            $id = $request->query('uuid_post');
            $post = $this->postsRepository->getByUuidPost($uuid);
        }

        catch (HttpException | PostNotFoundException $exception ) {
            return new ErrorResponse($exception->getMessage());
        }

        $this->postsRepository->savePost($post);
        return new SuccessResponse(['uuid_post'=>$id,
            'uuid_author'=>$post->getUuidUser(),
            'title'=>$post->getTitle(),
            'text'=>$post->getTextPost()]);
    }
}