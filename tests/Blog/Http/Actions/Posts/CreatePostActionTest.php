<?php

namespace Tgu\Laperdina\PhpUnit\Blog\Http\Actions\Posts;

use PHPUnit\Framework\TestCase;
use Tgu\Laperdina\Blog\Http\Actions\Posts\CreatePosts;
use Tgu\Laperdina\Blog\Http\ErrorResponse;
use Tgu\Laperdina\Blog\Http\Request;
use Tgu\Laperdina\Blog\Http\SuccessResponse;
use Tgu\Laperdina\Blog\Post;
use Tgu\Laperdina\Blog\Repositories\PostRepository\PostsRepositoryInterface;
use Tgu\Laperdina\Blog\UUID;
use Tgu\Laperdina\Exceptions\PostNotFoundException;

class CreatePostActionTest extends TestCase {
    private function postRepository(array $posts): PostsRepositoryInterface {
        return new class($posts) implements PostsRepositoryInterface {
            public array $array;

            public function __construct($array) {
                $this->array = $array;
            }

            public function savePost(Post $post): void {
            }

            public function getByUuidPost(UUID $uuid): Post {
                throw new PostNotFoundException('Post not found');
            }
        };
    }

    public function testItReturnErrorResponseIfNoUuid(): void {
        $request = new Request([], [], '');
        $postRepository = $this->postRepository([]);
        $action = new CreatePosts($postRepository);
        $response = $action->handle($request);
        $this->assertInstanceOf(ErrorResponse::class, $response);
        $this->expectOutputString('{"success":false,"reason":"No such query param in the request uuid_post"}');
        $response->send();
    }


    public function testItReturnErrorResponseIfUUIDNotFound(): void {
        $uuid = UUID::random();
        $request = new Request(['uuid_post'=>$uuid], [], '');
        $userRepository = $this->postRepository([]);
        $action = new CreatePosts($userRepository);
        $response = $action->handle($request);
        $this->assertInstanceOf(ErrorResponse::class, $response);
        $this->expectOutputString('{"success":false,"reason":"Not found"}');
        $response->send();
    }

    public function testItReturnSuccessfulResponse(): void {
        $uuid = UUID::random();
        $request = new Request(['uuid_post'=>"$uuid"], [],'');
        $postRepository = $this->postRepository([new Post($uuid,'cd6a4d34-3d65-44a5-bb52-90a0ce3efcb3','Title1','vaaaay')]);
        $action = new CreatePosts($postRepository);
        $response = $action->handle($request);
        var_dump($response);
        $this->assertInstanceOf(SuccessResponse::class, $response);
        $this->expectOutputString('{"success":true,"data":{"uuid_post":"Petya"}}');
        $response->send();
    }
}