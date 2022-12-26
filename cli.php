<?php

use Tgu\Laperdina\Blog\Repositories\UsersRepository\SqliteUsersRepository;
use Tgu\Laperdina\Blog\User;
use Tgu\Laperdina\Blog\Repositories\PostRepository\SqlitePostsRepository;
use Tgu\Laperdina\Blog\Post;
use Tgu\Laperdina\Blog\Comments;
use Tgu\Laperdina\Blog\UUID;
use Tgu\Laperdina\Blog\Commands\Arguments;
use Tgu\Laperdina\Blog\Commands\CreateUserCommand;
use Tgu\Laperdina\Exceptions\Argumentsexception;
use Tgu\Laperdina\Exceptions\CommandException;

require_once __DIR__ . 'vendor/autoload.php';

$conteiner = require __DIR__ .'/bootstrap.php';
$command = $conteiner->get(CreateUserCommand::class);

try {
    $command->handle(Arguments::fromArgv($argv));
}
catch (Argumentsexception|CommandException $exception) {
    echo $exception->getMessage();
}

//$connection = new PDO('sqlite:' . __DIR__ . '/blog.sqlite');
//
//$userRepository = new SqliteUsersRepository($connection);
//
//$userRepository->save(new Name('Name1', 'LasName1'), 'Test1');
//$userRepository->save(new Name('Name2', 'LasName2'), 'Test2');
//
//echo $userRepository->getByUuid(new UUID('f76cfc25-f8b2-4d15-9775-944db6648a82'));
//
//$PostRepository = new SqlitePostsRepository($connection);
//
//$PostRepository->savePost(new Post(UUID::random(),
//    'cd6a4d34-3d65-44a5-bb52-90a0ce3efcb3',
//    'Title1',
//    'qwerty'
//    ));
//$PostRepository->savePost(new Post(UUID::random(),
//    'f76cfc25-f8b2-4d15-9775-944db6648a82',
//    'title2',
//    'qwerty'
//    ));
//
//echo $PostRepository->getByUuidPost(new UUID('edb10650-3b52-4a8e-b05c-c5a1f167bed0'));
//
//$CommentsRepository = new \Tgu\Ryabova\Blog\Repositories\CommentsRepository\SqliteCommentsRepository($connection);
//
//$CommentsRepository->saveComment(new Comments(UUID::random(),
//    'edb10650-3b52-4a8e-b05c-c5a1f167bed0',
//    'f76cfc25-f8b2-4d15-9775-944db6648a82',
//    'qwerty'
//    ));
//$CommentsRepository->saveComment(new Comments(UUID::random(),
//    '5b78178a-eda3-4e85-9a62-90f5a0320c4e',
//    'cd6a4d34-3d65-44a5-bb52-90a0ce3efcb3',
//    'qwerty'
//    ));
//
//echo $CommentsRepository->getByUuidComment(new UUID('f165d492-bffe-448f-a499-b72d16a40f1b'));