<?php

use Tgu\Laperdina\Blog\Container\DIContainer;
use Tgu\Laperdina\Blog\Repositories\UsersRepository\SqliteUsersRepository;
use Tgu\Laperdina\Blog\Repositories\UsersRepository\UsersRepositoryInterface;
use Tgu\Laperdina\Blog\Repositories\CommentsRepository\CommentsRepositoryInterface;
use Tgu\Laperdina\Blog\Repositories\CommentsRepository\SqliteCommentsRepository;
use Tgu\Laperdina\Blog\Repositories\LikesRepository\LikesRepositoryInterface;
use Tgu\Laperdina\Blog\Repositories\LikesRepository\SqliteLikesRepository;
use Tgu\Laperdina\Blog\Repositories\PostRepository\PostRepositoryInterface;
use Tgu\Laperdina\Blog\Repositories\PostRepository\SqlitePostsRepository;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Psr\Log\LoggerInterface;
use Tgu\Laperdina\Blog\Http\Auth\BearerTokenAuthentication;
use Tgu\Laperdina\Blog\Http\Auth\PasswordAuthentication;
use Tgu\Laperdina\Blog\Http\Auth\PasswordAuthenticationInterface;
use Tgu\Laperdina\Blog\Http\Auth\TokenAuthenticationInterface;
use Tgu\Laperdina\Blog\Repositories\AuthTokenRepository\AuthTokenRepositoryInterface;
use Tgu\Laperdina\Blog\Repositories\AuthTokenRepository\SqliteAuthTokenRepository;

require_once  __DIR__ . '/vendor/autoload.php';

$conteiner = new DIContainer();

$conteiner->bind(
    PDO::class,
    new PDO('sqlite:'.__DIR__.'/blog.sqlite')
);

$conteiner->bind(
    UsersRepositoryInterface::class,
    SqliteUsersRepository::class
);

$conteiner->bind(
    TokenAuthenticationInterface::class,
    BearerTokenAuthentication::class
);

$conteiner->bind(
    PasswordAuthenticationInterface::class,
    PasswordAuthentication::class
);

$conteiner->bind(
    LikesRepositoryInterface::class,
    SqliteLikesRepository::class
);

$conteiner->bind(
    AuthTokenRepositoryInterface::class,
    SqliteAuthTokenRepository::class
);

$conteiner->bind(
    PostRepositoryInterface::class,
    SqlitePostsRepository::class
);

$conteiner->bind(
    CommentsRepositoryInterface::class,
    SqliteCommentsRepository::class
);


$conteiner->bind(
    LoggerInterface::class,
    (new Logger('blog'))->pushHandler(
        new StreamHandler(__DIR__.'/logs/blog.log',)) ->pushHandler(
            new StreamHandler(
                __DIR__.'/logs/blog.error.log',
                level: Logger::ERROR,
                bubble: false))->pushHandler(new StreamHandler( "php://stdout"),));

return $conteiner;