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
use Tgu\Laperdina\Exceptions\UserNotFoundException;
use Tgu\Laperdina\Blog\Http\Auth\TokenAuthenticationInterface;

class CreatePost implements ActionInterface {
    private PostsRepositoryInterface $postsRepository;
    private TokenAuthenticationInterface $authentication;

    public function __construct ($postsRepository, $authentication)
    {
        $this->postsRepository = $postsRepository;
        $this->authentication = $authentication;
    }

    public function handle(Request $request): Response {
        try {
            $id_author = $this->authentication->user($request);
        }
        catch (UserNotFoundException $exception) {
            return new ErrorResponse($exception->getMessage());
        }

        $postId = UUID::random();
        try {
            $post = new Post(
                $postId,
                $id_author,
                $request->jsonBodyField('title'),
                $request->jsonBodyField('text')
            );
        }
        catch (HttpException $exception){
            return new ErrorResponse($exception->getMessage());
        }

        $this->postsRepository->savePost($post);
        return new SuccessResponse(['uuid_post'=>(string)$postId]);

    }
}