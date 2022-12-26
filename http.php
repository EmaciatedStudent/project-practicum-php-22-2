<?php

use Tgu\Laperdina\Blog\Http\Actions\Comments\CreateComment;
use Tgu\Laperdina\Blog\Http\Actions\Posts\DeletePost;
use Tgu\Laperdina\Blog\Http\Actions\Users\CreateUser;
use Tgu\Laperdina\Blog\Http\Actions\Users\FindByUsername;
use Tgu\Laperdina\Blog\Http\ErrorResponse;
use Tgu\Laperdina\Blog\Http\Request;
use Tgu\Laperdina\Blog\Repositories\CommentsRepository\SqliteCommentsRepository;
use Tgu\Laperdina\Exceptions\HttpException;
use Dotenv\Dotenv;
use Psr\Log\LoggerInterface;
use Tgu\Laperdina\Blog\Http\Actions\Auth\Login;

require_once __DIR__ . '/vendor/autoload.php';

Dotenv::createImmutable(__DIR__)->safeLoad();

$conteiner = require __DIR__ .'/bootstrap.php';
$request = new Request($_GET, $_SERVER, file_get_contents('php://input'));
$logger= $conteiner->get(LoggerInterface::class);

try {
    $path=$request->path();
}
catch (HttpException $exception) {
    $logger->warning($exception->getMessage());
    (new ErrorResponse($exception->getMessage()))->send();
    return;
}

try {
    $method = $request->method();
}
catch (HttpException $exception) {
    $logger->warning($exception->getMessage());
    (new ErrorResponse($exception->getMessage()))->send();
    return;
}

$routes =[
    'GET'=>['/users/show'=>FindByUsername::class],
    'POST'=>[
        '/login'=> Login::class,
        '/users/create'=>CreateUser::class,
        '/posts/create'=> CreatePost::class,
        '/comment/create'=> CreateComment::class,
        '/like/create'=> CreateLikes::class]
];

if (!array_key_exists($path,$routes[$method])) {
    $message = "Route not found: $path $method";
    $logger->warning($message);
    (new ErrorResponse($message))->send();
    return;
}

$actionClassName = $routes[$method][$path];
$action = $conteiner->get($actionClassName);
try {
    $response = $action->handle($request);
    $response->send();
}
catch (Exception $exception) {
    $logger->warning($exception->getMessage());
    (new ErrorResponse($exception->getMessage()))->send();
    return;
}