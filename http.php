<?php

use Tgu\Laperdina\Blog\Http\Actions\Comments\CreateComment;
use Tgu\Laperdina\Blog\Http\Actions\Posts\DeletePost;
use Tgu\Laperdina\Blog\Http\ErrorResponse;
use Tgu\Laperdina\Blog\Http\Request;
use Tgu\Laperdina\Blog\Repositories\CommentsRepository\SqliteCommentsRepository;
use Tgu\Laperdina\Exceptions\HttpException;

require_once __DIR__ . '/vendor/autoload.php';

$request = new Request($_GET, $_SERVER, file_get_contents('php://input'));

try {
    $path=$request->path();
}

catch (HttpException $exception) {
    (new ErrorResponse($exception->getMessage()))->send();

    return;
}

try {
    $method = $request->method();
}
catch (HttpException $exception) {
    (new ErrorResponse($exception->getMessage()))->send();

    return;
}

$routes =[
    'POST'=>['/posts/comment'=>new CreateComment (
        new SqliteCommentsRepository (
            new PDO('sqlite:'.__DIR__.'/blog.sqlite')))],
    'DELETE'=>['/post/delete' => new DeletePost (
        new SqlitePostRepository (
            new PDO('sqlite:'.__DIR__.'/blog.sqlite')))],
];

if (!array_key_exists($path,$routes[$method])) {
    (new ErrorResponse('Not found'))->send();

    return;
}

$action = $routes[$method][$path];

try {
    $response = $action->handle($request);
    $response->send();
}
catch (Exception $exception) {
    (new ErrorResponse($exception->getMessage()))->send();

    return;
}