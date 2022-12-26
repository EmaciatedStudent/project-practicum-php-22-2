<?php

use Tgu\Laperdina\Blog\Container\DIContainer;
use Tgu\Laperdina\Blog\Repositories\UserRepository\SqliteUsersRepository;
use Tgu\Laperdina\Blog\Repositories\UserRepository\UsersRepositoryInterface;

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

return $conteiner;